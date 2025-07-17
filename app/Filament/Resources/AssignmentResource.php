<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignmentResource\Pages;
use App\Filament\Resources\AssignmentResource\RelationManagers;
use App\Models\Assignment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput\Mask;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Project Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('Assigned User')
                    ->required()
                    ->helperText('Select a user to assign this task to.')
                    ->relationship('user', 'name'),
                Forms\Components\Select::make('role')
                    ->options([
                        'translator' => 'Translator',
                        'editor' => 'Editor',
                        'proofreader' => 'Proofreader',
                        'interpreter' => 'Interpreter',
                    ])
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'translation' => 'Translation',
                        'interpretation' => 'Interpretation',
                        'proofreading' => 'Proofreading',
                        'editing' => 'Editing',
                        'localization' => 'Localization',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('language_pair')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('e.g. EN→ES'),
                Forms\Components\Select::make('status')
                    ->options([
                        'not_started' => 'Not Started',
                        'in_progress' => 'In Progress',
                        'submitted' => 'Submitted',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->default('not_started')
                    ->required(),
                Forms\Components\DatePicker::make('due_date')
                    ->nullable()
                    ->label('Due Date'),
                Forms\Components\TextInput::make('word_count')
                    ->helperText('Total number of words in the assignment.')
                    ->nullable()
                    ->label('Word Count'),
                Forms\Components\TextInput::make('rate_per_word')
                    ->helperText('Rate per word for the assignment.')
                    ->nullable()
                    ->numeric()
                    ->label('Rate per Word'),
                Forms\Components\Textarea::make('instructions')
                    ->helperText('Provide detailed instructions for the assignment.')
                    ->nullable()
                    ->maxLength(1000)
                    ->label('Instructions'),
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Assigned User')
                    ->badge(),
                Tables\Columns\TextColumn::make('role')->badge(),
                Tables\Columns\TextColumn::make('project.name')
                    ->label('Project')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')->badge(),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('due_date'),
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
            'index' => Pages\ListAssignments::route('/'),
            'create' => Pages\CreateAssignment::route('/create'),
            'edit' => Pages\EditAssignment::route('/{record}/edit'),
        ];
    }
}
