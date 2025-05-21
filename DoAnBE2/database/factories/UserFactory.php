<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition()
    {
        $roles = ['User', 'Admin', 'Vip']; // để random role trong factory nếu muốn
        return [
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('123'), // mặc định 'password'
            'role' => 'User', // sẽ override trong seeder nếu cần
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'is_active' => $this->faker->boolean(90), // 90% true
            'avatar' => $this->faker->optional()->imageUrl(100, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
