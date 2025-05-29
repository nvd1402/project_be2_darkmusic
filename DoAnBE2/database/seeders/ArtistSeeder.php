<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ArtistSeeder extends Seeder
{
    public function run(): void
    {
        $artistNames = [
            'Vũ Trần',
            'Thái Đinh',
            'Nguyên Hà',
            'Trang (Orange)',
            'Phan Mạnh Quỳnh',
            'Lê Cát Trọng Lý',
            'Bùi Lan Hương',
            'Tùng (Ngọt)',
            'Văn Mai Hương',
            'Hoàng Dũng',
            'Hà Lê',
            'Minh (Da LAB)',
            'Kimmese',
            'Đen Vâu',
            'Kha (Ca sĩ)',
            'Ngọt Band',
            'Chillies Band',
            'Trung Quân Idol',
            'Tiên Tiên',
            'Quang Đăng Trình',
            'Lộn Xộn Band',
            'Cá Hồi Hoang',
            'Thịnh Suy',
            'Phạm Anh Khoa',
            'Hải Sâm',
            'Phoebe Bridgers',
            'Sufjan Stevens',
            'Maggie Rogers',
            'Bon Iver',
            'Mac DeMarco',
            'Conor Oberst',
            'Clairo Cotton',
            'Lana Del Rey',
            'Julien Baker',
            'Lucy Dacus',
            'Elliott Smith',
            'Joji Miller',
            'AURORA Aksnes',
            'King Princess',
            'Kurt Vile',
            'Beabadoobee',
            'Rex Orange County',
            'Ben Howard',
            'Iron & Wine',
            'Fleet Foxes',
            'Alex G',
            'Faye Webster',
            'Jose Gonzalez',
            'Grizzly Bear',
            'The Japanese House'
        ];

        $imageArtists = Storage::disk('public')->files('artists');

        if (empty($imageArtists)) {
            $this->command->warn('Không tìm thấy ảnh trong thư mục');

            $imageArtists = ['default-1.jpg'];
        }

        $data = [];

        for ($i = 0; $i < 100; $i++) {
            $randomName = $artistNames[array_rand($artistNames)];
            $randomImage = $imageArtists[array_rand($imageArtists)];

            $data[] = [
                'name_artist' => $randomName,
                'image_artist' => basename($randomImage),
                'category_id' => rand(1, 12),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('artists')->insert($data);
    }
}
