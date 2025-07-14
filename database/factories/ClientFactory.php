<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;

class ClientFactory extends Factory
{
    protected $model = Client::class;
    
    public function definition(): array
    {
        return [
            'tenant_id' => 1, // You may override this in the seeder
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'company_name' => $this->faker->company(),
            'phone' => $this->faker->phoneNumber(),
            'notes' => $this->faker->sentence(),
        ];
    }
}
