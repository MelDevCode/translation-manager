<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Tenant;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static ?string $tenantOwnershipRelationshipName = 'tenants';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create')
                    ->dehydrateStateUsing(fn ($state) => \Hash::make($state))
                    ->label('Password')
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->required()
                    ->options([
                        'admin' => 'Admin',
                        'translator' => 'Translator',
                        'editor' => 'Editor',
                        'interpreter' => 'Interpreter',
                        'proofreader' => 'Proofreader',
                        'project_manager' => 'Project Manager',
                    ]),
                Forms\Components\TagsInput::make('language_pairs')
                    ->placeholder('Add language pairs like EN→ES')
                    ->label('Language Pairs')
                    ->suggestions(['EN→ES', 'ES→EN', 'EN→FR', 'FR→EN']),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
                       
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->sortable(),
                Tables\Columns\TextColumn::make('email')
                ->sortable(),
                Tables\Columns\TextColumn::make('role')
                ->sortable(),
                Tables\Columns\TextColumn::make('language_pairs')
                    ->label('Language Pairs')
                    ->formatStateUsing(fn ($state) => implode(', ', $state)),

                Tables\Columns\TextColumn::make('availability_status')
                    ->label('Availability Status')
                    ->formatStateUsing(fn ($state) => $state ? 'Available' : 'Unavailable')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'translator' => 'Translator',
                        'editor' => 'Editor',
                        'interpreter' => 'Interpreter',
                        'proofreader' => 'Proofreader',
                        'project_manager' => 'Project Manager',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
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
             'index' => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
