<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GlossaryResource\Pages;
use App\Filament\Resources\GlossaryResource\RelationManagers;
use App\Models\Glossary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GlossaryResource extends Resource
{
    protected static ?string $model = Glossary::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Language Resources';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\CheckboxList::make('projects')
                    ->relationship('projects', 'name')
                    ->columns(2)
                    ->label('Associated Projects'),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Select::make('source_language')
                    ->options([
                        'en' => 'English',
                        'fr' => 'French',
                        'de' => 'German',
                        'es' => 'Spanish',
                        'it' => 'Italian',
                        'pt' => 'Portuguese',
                        'zh' => 'Chinese',
                        'ja' => 'Japanese',
                        'ru' => 'Russian',
                    ])
                    ->required(),
                Forms\Components\Select::make('target_language')
                    ->options([
                        'en' => 'English',
                        'fr' => 'French',
                        'de' => 'German',
                        'es' => 'Spanish',
                        'it' => 'Italian',
                        'pt' => 'Portuguese',
                        'zh' => 'Chinese',
                        'ja' => 'Japanese',
                        'ru' => 'Russian',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('source_language'),
                Tables\Columns\TextColumn::make('target_language'),
                Tables\Columns\TextColumn::make('projects.name')
                    ->label('Project(s)')
                    ->formatStateUsing(fn ($state, $record) => 
                        $record->projects->isNotEmpty()
                            ? $record->projects->pluck('name')->join(', ')
                            : '—'
                    ),
            ])
            ->filters([
                //
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
            'index' => Pages\ListGlossaries::route('/'),
            //'create' => Pages\CreateGlossary::route('/create'),
            //'edit' => Pages\EditGlossary::route('/{record}/edit'),
        ];
    }
}
