<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {

        $categories = [
            'Pop',
            'Rock',
            'Hip Hop',
            'R&B',
            'Rap',
            'Jazz',
        ];

        $data = array_map(function ($name) {
            return [
                'tentheloai' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $categories);

        DB::table('categories')->insert($data);
    }
}
