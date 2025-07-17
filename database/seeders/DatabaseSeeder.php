<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Client;
use App\Models\Project;

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

        // Create clients
        Client::create([
            'tenant_id' => $tenant1->id,
            'name' => 'Yuji Itadori',
            'email' => 'yuji@jujutsu-kaisen.com',
            'company_name' => 'Jujutsu Kaisen Company',
            'phone' => '123-456-7890',
            'notes' => 'Special grade sorcerer.',
        ]);

        Client::create([
            'tenant_id' => $tenant2->id,
            'name' => 'Levi Ackerman',
            'email' => 'levi@snk.com',
            'company_name' => 'Shingeki no Kyojin',
            'phone' => '987-654-3210',
            'notes' => 'Captain of the Survey Corps.',
        ]);

        // Get some existing clients and users for seeding
        $client1 = Client::where('name', 'Yuji Itadori')->first();
        $client2 = Client::where('name', 'Levi Ackerman')->first();

        Project::create([
            'tenant_id' => $tenant1->id,
            'client_id' => $client1->id,
            'created_by' => $shumei->id,
            'name' => 'Website Localization Project',
            'source_language' => 'English',
            'target_language' => 'Japanese',
            'status' => 'not_started',
            'deadline' => now()->addDays(10),
            'instructions' => 'Translate all UI components and pages for the Japanese market.',
        ]);

        Project::create([
            'tenant_id' => $tenant2->id,
            'client_id' => $client2->id,
            'created_by' => $ritsuka->id,
            'name' => 'Comic Translation',
            'source_language' => 'Japanese',
            'target_language' => 'English',
            'status' => 'in_progress',
            'deadline' => now()->addDays(15),
            'instructions' => 'Maintain original tone and character personality. Target audience is teens.',
        ]);

        Project::create([
            'tenant_id' => $tenant3->id,
            'client_id' => $client2->id,
            'created_by' => $mafuyu->id,
            'name' => 'Marketing Copy Transcreation',
            'source_language' => 'English',
            'target_language' => 'French',
            'status' => 'delivered',
            'deadline' => now()->addDays(20),
            'instructions' => 'Adapt tone to French Canadian culture. Focus on persuasive language.',
        ]);
    }
}
