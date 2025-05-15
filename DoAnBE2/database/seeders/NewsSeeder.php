<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $titles = [
            'Lễ hội âm nhạc mùa hè chính thức trở lại',
            'Ca sĩ A ra mắt album mới gây bão',
            'Top 10 ca khúc đang thịnh hành tuần này',
            'Nhạc trẻ Việt Nam và sự phát triển vượt bậc',
            'Giải thưởng âm nhạc quốc tế vinh danh nghệ sĩ Việt'
        ];

        $units = ['Báo Tuổi Trẻ', 'Zing News', 'VNExpress', 'Dân Trí', 'Báo Thanh Niên'];

        $images = [
            'news1.jpg',
            'news2.jpg',
            'news3.jpg',
            'news4.jpg',
            'news5.jpg'
        ];

        for ($i = 1; $i <= 20; $i++) {
            DB::table('news')->insert([
                'tieude' => $titles[array_rand($titles)],
                'noidung' => 'Đây là nội dung tin tức mẫu số ' . $i . ' với nhiều thông tin hấp dẫn và đầy đủ về sự kiện âm nhạc, nghệ sĩ và các hoạt động nghệ thuật.',
                'donvidang' => $units[array_rand($units)],
                'hinhanh' => $images[array_rand($images)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
