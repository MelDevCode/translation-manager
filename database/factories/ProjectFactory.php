<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\Tenant;
use App\Models\Client;
use App\Models\User;


class ProjectFactory extends Factory
{
    protected static ?string $model = Project::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'client_id' => Client::factory(),
            'created_by' => User::factory(),
            'name' => $this->faker->sentence,
            'source_language' => 'en',
            'target_language' => 'es',
            'status' => 'not_started',
            'deadline' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'instructions' => $this->faker->paragraph,
        ];
    }
}
