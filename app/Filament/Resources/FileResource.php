<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileResource\Pages;
use App\Filament\Resources\FileResource\RelationManagers;
use App\Models\File;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;

class FileResource extends Resource
{
    protected static ?string $model = File::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationGroup = 'Project Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->label('Project')
                    ->relationship('project', 'name')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'Word' => 'Word',
                        'PDF' => 'PDF',
                        'PPT' => 'PPT',
                        'Excel' => 'Excel',
                        'Text' => 'Text',
                        'InDesign' => 'InDesign',
                        'HTML' => 'HTML',
                        'JSON' => 'JSON',
                        'XML' => 'XML',
                        'YAML' => 'YAML',
                        'PO/MO' => 'PO/MO',
                        'Strings' => 'Strings',
                        'XLIFF' => 'XLIFF',
                        'Audio' => 'Audio',
                        'Video' => 'Video',
                        'Subtitles' => 'Subtitles',
                        'Photoshop' => 'Photoshop',
                        'Illustrator' => 'Illustrator',
                        'Image' => 'Image',
                        'Scanned PDF' => 'Scanned PDF',
                        'CAT Package' => 'CAT Package',
                        'MemoQ Package' => 'MemoQ Package',
                        'Other' => 'Other',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('language')
                    ->required(),
                Forms\Components\FileUpload::make('file_path')
                    ->directory('uploads') // or any subfolder
                    ->required()
                    ->preserveFilenames() // optional: keeps original name
                    ->disk('public') // make sure your disk is configured
                    ->visibility('public'), // so you can access it via URL
                Forms\Components\Select::make('uploaded_by')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\DateTimePicker::make('uploaded_at')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.name')
                    ->label('Project'),
                Tables\Columns\TextColumn::make('type')
                ->label('File Type')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Word', 'PDF', 'PPT', 'Excel', 'Text', 'InDesign' => 'blue',
                    'HTML', 'JSON', 'XML', 'YAML', 'PO/MO', 'Strings', 'XLIFF' => 'purple',
                    'Audio', 'Video', 'Subtitles' => 'orange',
                    'Photoshop', 'Illustrator', 'Image', 'Scanned PDF' => 'pink',
                    'CAT Package', 'MemoQ Package' => 'gray',
                    'Other' => 'secondary',
                    default => 'primary',
                })
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'Word' => '📝 Word',
                    'PDF' => '📄 PDF',
                    'PPT' => '📊 PowerPoint',
                    'Excel' => '📈 Excel',
                    'Text' => '📃 Text File',
                    'InDesign' => '🖋 InDesign',
                    'HTML' => '🌐 HTML',
                    'JSON' => '🔧 JSON',
                    'XML' => '🧩 XML',
                    'YAML' => '📂 YAML',
                    'PO/MO' => '🗂 PO/MO',
                    'Strings' => '🔤 .strings',
                    'XLIFF' => '📦 XLIFF',
                    'Audio' => '🎧 Audio',
                    'Video' => '🎞 Video',
                    'Subtitles' => '💬 Subtitles',
                    'Photoshop' => '🖼 Photoshop',
                    'Illustrator' => '🎨 Illustrator',
                    'Image' => '🖼 Image',
                    'Scanned PDF' => '📷 Scanned PDF',
                    'CAT Package' => '📦 CAT Package',
                    'MemoQ Package' => '📦 MemoQ',
                    'Other' => '❓ Other',
                    default => $state,
                }),
                Tables\Columns\TextColumn::make('language')
                ->badge()
                ->colors([
                    'English' => 'blue',
                    'Spanish' => 'red',
                ]),
                Tables\Columns\TextColumn::make('file_path')
                ->label('File')
                ->formatStateUsing(function ($state) {
                    $fileName = basename($state); // remove the path or hash
                    $url = Storage::disk('public')->url($state); // generate public URL
                    $ext = pathinfo($state, PATHINFO_EXTENSION);
                    $icon = match (strtolower($ext)) {
                        'pdf' => '📄',
                        'doc', 'docx' => '📝',
                        'xls', 'xlsx' => '📊',
                        'ppt', 'pptx' => '📈',
                        'jpg', 'jpeg', 'png', 'gif' => '🖼',
                        'mp3', 'wav' => '🎧',
                        'mp4', 'mov' => '🎞',
                        default => '📁',
                    };
                    return "<a href='{$url}' class='text-primary-600 underline' target='_blank'>{$icon} {$fileName}</a>";
                })
                ->html(), // Important: allow HTML rendering
                Tables\Columns\TextColumn::make('user.name')
                ->label('Uploaded By'),
                Tables\Columns\TextColumn::make('uploaded_at'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'Word' => 'Word',
                        'PDF' => 'PDF',
                        'PPT' => 'PPT',
                        'Excel' => 'Excel',
                        'Text' => 'Text',
                        'InDesign' => 'InDesign',
                        'HTML' => 'HTML',
                        'JSON' => 'JSON',
                        'XML' => 'XML',
                        'YAML' => 'YAML',
                        'PO/MO' => 'PO/MO',
                        'Strings' => 'Strings',
                        'XLIFF' => 'XLIFF',
                        'Audio' => 'Audio',
                        'Video' => 'Video',
                        'Subtitles' => 'Subtitles',
                        'Photoshop' => 'Photoshop',
                        'Illustrator' => 'Illustrator',
                        'Image' => 'Image',
                        'Scanned PDF' => 'Scanned PDF',
                        'CAT Package' => 'CAT Package',
                        'MemoQ Package' => 'MemoQ Package',
                        'Other' => 'Other',
                    ]),               
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFiles::route('/'),
            //'create' => Pages\CreateFile::route('/create'),
            //'edit' => Pages\EditFile::route('/{record}/edit'),
        ];
    }
}
