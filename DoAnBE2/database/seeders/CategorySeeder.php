<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;


class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
    ['name' => 'Pop', 'image' => 'pop.jpg'],
    ['name' => 'Rock', 'image' => 'rock.jpg'],
    ['name' => 'Hip Hop', 'image' => 'hiphop.jpg'],
    ['name' => 'R&B', 'image' => 'rnb.jpg'],
    ['name' => 'Rap', 'image' => 'rap.jpg'],
    ['name' => 'Jazz', 'image' => 'jazz.jpg'],
    ['name' => 'Blues', 'image' => 'blues.jpg'],
    ['name' => 'Nhạc Trẻ', 'image' => 'nhactre.jpg'],
    ['name' => 'Nhạc Vàng', 'image' => 'nhacvang.jpg'],
    ['name' => 'Nhạc Trịnh', 'image' => 'nhactrinh.jpg'],
    ['name' => 'Nhạc Thiếu Nhi', 'image' => 'thieunhi.jpg'],
    ['name' => 'Nhạc Không Lời', 'image' => 'khongloi.jpg'],
    ['name' => 'Ballad', 'image' => 'ballad.jpg'],
    ['name' => 'EDM', 'image' => 'edm.jpg'],
    ['name' => 'Dance', 'image' => 'dance.jpg'],
    ['name' => 'Trance', 'image' => 'trance.jpg'],
    ['name' => 'House', 'image' => 'house.jpg'],
    ['name' => 'Techno', 'image' => 'techno.jpg'],
    ['name' => 'Nhạc Phim', 'image' => 'soundtrack.jpg'],
    ['name' => 'Cổ Điển', 'image' => 'classical.jpg'],
    ['name' => 'Bolero', 'image' => 'bolero.jpg'],
    ['name' => 'Country', 'image' => 'country.jpg'],
    ['name' => 'Reggae', 'image' => 'reggae.jpg'],
    ['name' => 'Indie', 'image' => 'indie.jpg'],
    ['name' => 'Folk', 'image' => 'folk.jpg'],
    ['name' => 'Nhạc Cách Mạng', 'image' => 'cachmang.jpg'],
    ['name' => 'Nhạc Hòa Tấu', 'image' => 'hoatau.jpg'],
    ['name' => 'Nhạc Xuân', 'image' => 'xuan.jpg'],
    ['name' => 'Nhạc Noel', 'image' => 'noel.jpg'],
    ['name' => 'Nhạc Thiền', 'image' => 'thien.jpg'],
];
    foreach ($categories as $category) {
        $sourcePath = database_path('seeders/sample_images/' . $category['image']);
        $destinationPath = storage_path('app/public/category/' . $category['image']);

        if (!File::exists($destinationPath) && File::exists($sourcePath)) {
            File::copy($sourcePath, $destinationPath);
        }
    }

    // Insert dữ liệu vào DB
    $nhoms = ['Nhạc Rock', 'Nhạc Remix', 'Nhạc Nổi Bật', 'Nhạc Mới'];

    $data = array_map(function ($item) use ($nhoms) {
        return [
            'tentheloai' => $item['name'],
            'nhom' => Arr::random($nhoms),
            'image' => $item['image'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }, $categories);

    DB::table('categories')->insert($data);
}}