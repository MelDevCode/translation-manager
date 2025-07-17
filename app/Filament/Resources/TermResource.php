<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TermResource\Pages;
use App\Filament\Resources\TermResource\RelationManagers;
use App\Models\Term;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TermResource extends Resource
{
    protected static ?string $model = Term::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('source_term')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('target_term')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('glossary_id')
                    ->relationship('glossary', 'name')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'word' => 'Word',
                        'phrase' => 'Phrase',
                        'acronym' => 'Acronym',
                        'abbreviation' => 'Abbreviation',
                        'idiom' => 'Idiom',
                        'collocation' => 'Collocation',
                    ])
                    ->required(),
                Forms\Components\Select::make('part_of_speech')
                    ->options([
                        'noun' => 'Noun',
                        'verb' => 'Verb',
                        'adjective' => 'Adjective',
                        'adverb' => 'Adverb',
                        'pronoun' => 'Pronoun',
                        'preposition' => 'Preposition',
                        'conjunction' => 'Conjunction',
                        'interjection' => 'Interjection',
                    ])
                    ->required(),
                Forms\Components\Select::make('domain')
                    ->options([
                        'general' => 'General',
                        'technical' => 'Technical',
                        'legal' => 'Legal',
                        'medical' => 'Medical',
                        'financial' => 'Financial',
                        'IT' => 'IT',
                        'marketing' => 'Marketing',
                        'scientific' => 'Scientific',
                        'education' => 'Education',
                        'engineering' => 'Engineering',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('context')
                    ->rows(3),
                Forms\Components\Select::make('created_by')
                    ->label('Created By')
                    ->relationship('user', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('source_term'),
                Tables\Columns\TextColumn::make('target_term'),
                Tables\Columns\TextColumn::make('glossary.name')->label('Glossary'),
                Tables\Columns\TextColumn::make('type')
                    ->badge(),
                Tables\Columns\TextColumn::make('part_of_speech')
                    ->badge(),
                Tables\Columns\TextColumn::make('domain')
                    ->badge(),
                Tables\Columns\TextColumn::make('context')
                    ->badge(),
                Tables\Columns\TextColumn::make('user.name')->label('Created By'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('glossary_id')
                    ->relationship('glossary', 'name'),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'word' => 'Word',
                        'phrase' => 'Phrase',
                        'acronym' => 'Acronym',
                        'abbreviation' => 'Abbreviation',
                        'idiom' => 'Idiom',
                        'collocation' => 'Collocation',
                    ]),
                Tables\Filters\SelectFilter::make('part_of_speech')
                    ->options([     
                        'noun' => 'Noun',
                        'verb' => 'Verb',
                        'adjective' => 'Adjective',
                        'adverb' => 'Adverb',
                        'pronoun' => 'Pronoun',
                        'preposition' => 'Preposition',
                        'conjunction' => 'Conjunction',
                        'interjection' => 'Interjection',
                    ]),
                Tables\Filters\SelectFilter::make('domain')
                    ->options([
                        'general' => 'General',
                        'technical' => 'Technical',
                        'legal' => 'Legal',
                        'medical' => 'Medical',
                        'financial' => 'Financial',
                        'IT' => 'IT',
                        'marketing' => 'Marketing',
                        'scientific' => 'Scientific',
                        'education' => 'Education',
                        'engineering' => 'Engineering',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTerms::route('/'),
            //'create' => Pages\CreateTerm::route('/create'),
            //'edit' => Pages\EditTerm::route('/{record}/edit'),
        ];
    }
}
