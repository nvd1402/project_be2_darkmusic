<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Tắt kiểm tra khóa ngoại để truncate bảng
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('categories')->truncate();

        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            'Pop',
            'Rock',
            'Hip Hop',
            'R&B',
            'Rap',
            'Jazz',
            'Blues',
            'Nhạc Trẻ',
            'Nhạc Vàng',
            'Nhạc Trịnh',
            'Nhạc Thiếu Nhi',
            'Nhạc Không Lời'
        ];

        $nhom = ['Nhạc Rock', 'Nhạc Remix', 'Nhạc Nổi Bật', 'Nhạc Mới']; // Các nhóm bạn cần

        $data = array_map(function ($name) use ($nhom) {
            return [
                'tentheloai' => $name,
                'nhom' => Arr::random($nhom),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $categories);

        DB::table('categories')->insert($data);
    }
}
