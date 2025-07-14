<?php

namespace App\Filament\Pages\Tenancy;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Support\Colors\Color;

class EditTenantProfilePage extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Tenant profile';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Phone')
                    ->required()
                    ->tel()
                    ->maxLength(20)
                    ->helperText('Include country code if applicable'),
                TextInput::make('website')
                    ->label('Website')
                    ->url()
                    ->maxLength(255),
                FileUpload::make('logo')
                    ->label('Logo')
                    ->image()
                    ->disk('public')
                    ->directory('tenant-logos') // save in /storage/app/public/tenant-logos
                    ->visibility('public')
                    ->maxSize(1024),// 1MB    
            ]);
    }

    public function getFormModel(): \App\Models\Tenant
    {
        return Filament::getTenant();
    }
}