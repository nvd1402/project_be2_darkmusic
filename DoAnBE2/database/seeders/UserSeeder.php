<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');  // Tắt kiểm tra foreign key

        User::truncate();

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');  // Bật lại kiểm tra

        // Tạo user
        User::factory()->count(5)->state([
            'role' => 'Admin',
            'status' => 'active',
            'is_active' => true,
        ])->create();

        User::factory()->count(30)->state([
            'role' => 'Vip',
            'status' => 'active',
            'is_active' => true,
        ])->create();

        User::factory()->count(65)->state([
            'role' => 'User',
        ])->create();
    }
}
