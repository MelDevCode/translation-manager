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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;


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
                    ->maxLength(255)
                    ->visibleOn('create', 'edit') // Optional, hides on view
                    ->dehydrated(fn ($state) => filled($state)), // Don't update if left blank
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
                Forms\Components\Select::make('availability_status')
                    ->required()
                    ->options([
                        'available' => 'Available',
                        'unavailable' => 'Unavailable',
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
                ->badge()
                ->colors([
                    'admin' => 'primary',
                    'translator' => 'info',
                    'editor' => 'warning',
                    'interpreter' => 'success',
                    'proofreader' => 'secondary',
                    'project_manager' => 'danger',
                ])
                ->sortable(),
                Tables\Columns\TextColumn::make('language_pairs')
                ->label('Language Pairs')
                ->formatStateUsing(function ($state) {
                    // Handle null or malformed state
                    if (is_array($state)) {
                        return implode(', ', $state);
                    }

                    // In case state is a JSON string (rare but possible)
                    if (is_string($state)) {
                        $decoded = json_decode($state, true);
                        return is_array($decoded) ? implode(', ', $decoded) : $state;
                    }

                    return $state;
                }),
                Tables\Columns\TextColumn::make('availability_status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'available' => 'success',
                        'unavailable' => 'danger',
                    ])
                    ->formatStateUsing(fn ($state) => $state === 'available' ? 'Available' : 'Unavailable')
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
                        'available' => 'Available',
                        'unavailable' => 'Unavailable',
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
