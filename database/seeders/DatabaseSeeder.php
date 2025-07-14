<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create tenants
        $tenant1 = Tenant::create([
            'name' => 'Translation Agency',
            'slug' => 'translation-agency',
            'email' => 'contact@translation-agency.com',
            'phone' => '123-456-7890',
            'website' => 'https://translation-agency.com',
        ]);

        $tenant2 = Tenant::create([
            'name' => 'Localization Agency',
            'slug' => 'localization-agency',
            'email' => 'hello@localization-agency.com',
            'phone' => '987-654-3210',
            'website' => 'https://localization-agency.com',
        ]);

        $tenant3 = Tenant::create([
            'name' => 'Language Provider',
            'slug' => 'language-provider',
            'email' => 'info@language-provider.com',
            'phone' => '555-000-9999',
            'website' => 'https://language-provider.com',
        ]);

        // Create users
        $mafuyu = User::create([
            'name' => 'Mafuyu Sato',
            'email' => 'mafuyu@example.com',
            'role' => 'translator',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $ritsuka = User::create([
            'name' => 'Ritsuka Uenoyama',
            'email' => 'ritsuka@example.com',
            'role' => 'editor',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $shumei = User::create([
            'name' => 'Shumei Sasaki',
            'email' => 'shumei@example.com',
            'role' => 'project_manager',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        // Attach users to tenants
        $mafuyu->tenants()->attach([$tenant1->id, $tenant2->id, $tenant3->id]);
        $ritsuka->tenants()->attach([$tenant1->id, $tenant2->id]);
        $shumei->tenants()->attach([$tenant2->id, $tenant3->id]);
    }
}
