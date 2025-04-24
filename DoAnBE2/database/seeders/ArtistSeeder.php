<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArtistSeeder extends Seeder
{
    public function run(): void
    {
        $artisanName = ['Tùng', 'Trang', 'Thắng', 'Ngọt', 'Dương Domic', 'Sơn Tùng MTP', 'Keshi', 'KoQuet', 'Những Đứa Trẻ', 'Lope Dope'];

        sort($artisanName);

        $data = array_map(function ($name) {
            return [
                'name_artist' => $name,
                'category_id' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $artisanName);

        DB::table('artists')->insert($data);
    }
}
