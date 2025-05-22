<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlbumSeeder extends Seeder
{
    public function run(): void
    {
        $albumNames = [
            'Mùa Hè Bất Tận',
            'Lặng Lẽ Yêu',
            'Đêm Không Ngủ',
            'Tình Ca Du Dương',
            'Dòng Thời Gian',
            'Ký Ức Tháng 4',
            'Remix Cháy Phố',
            'Một Thoáng Yêu Đương',
            'Chạm Đến Giấc Mơ',
            'Thanh Âm Cuối Cùng',
        ];

        $artistNames = [
            'Vũ Trần',
            'Thái Đinh',
            'Nguyên Hà',
            'Trang (Orange)',
            'Phan Mạnh Quỳnh',
            'Đen Vâu',
            'Ngọt Band',
            'Chillies Band',
            'Trung Quân Idol',
            'Tiên Tiên',
        ];

        $imageCovers = Storage::disk('public')->files('album_images');

        if (empty($imageCovers)) {
            $this->command->warn('Không tìm thấy ảnh trong thư mục album_images. Dùng ảnh mặc định.');
            $imageCovers = ['default_album.jpg'];
        }

        $data = [];

        for ($i = 0; $i < 50; $i++) {
            $randomAlbum = $albumNames[array_rand($albumNames)];
            $randomArtist = $artistNames[array_rand($artistNames)];
            $randomImage = $imageCovers[array_rand($imageCovers)];

            $data[] = [
                'ten_album' => $randomAlbum,
                'nghe_si' => $randomArtist,
                'anh_bia' => basename($randomImage),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('albums')->insert($data);
    }
}
