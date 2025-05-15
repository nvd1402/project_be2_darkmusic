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
            'Blues',
            'Country',
            'Classical',
            'Electronic',
            'Dance',
            'Reggae',
            'Folk',
            'Metal',
            'Alternative',
            'Indie',
            'Soul',
            'Disco',
            'Techno',
            'House',
            'Trance',
            'Dubstep',
            'K-Pop',
            'J-Pop',
            'Lo-fi',
            'Chill',
            'Ambient',
            'EDM',
            'Trap',
            'Funk',
            'Ballad',
            'Acoustic',
            'Opera',
            'Instrumental',
            'Punk',
            'Grunge',
            'Hard Rock',
            'Garage',
            'Ska',
            'Progressive Rock',
            'Bolero',
            'Nhạc Trẻ',
            'Nhạc Vàng',
            'Nhạc Cách Mạng',
            'Nhạc Trịnh',
            'Nhạc Thiếu Nhi',
            'Nhạc Remix',
            'Nhạc EDM Việt',
            'Nhạc Phật Giáo',
            'Nhạc Không Lời'
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
