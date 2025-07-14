<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Tenant;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Facades\Filament;

class RegisterTenantPage extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register Organization';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(Tenant::class, 'name'),
                TextInput::make('email')
                    ->label('Organization Email')
                    ->email()
                    ->nullable(),
                TextInput::make('phone')
                    ->label('Phone Number')
                    ->tel()
                    ->nullable(),
                TextInput::make('website')
                    ->label('Website')
                    ->url()
                    ->nullable(),
            ]);
    }

    protected function handleRegistration(array $data): Tenant
    {
        // Auto-create slug
        $data['slug'] = Str::slug($data['name']);

        // Create the tenant
        $tenant = Tenant::create($data);

        // Attach the current user to the tenant
        Filament::auth()->user()->tenants()->attach($tenant->id);

        return $tenant;
    }
}