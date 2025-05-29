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

        $categories = $categories = [
    ['name' => 'Pop', 'image' => 'pop.jpg', 'description' => 'Nhạc Pop là dòng nhạc phổ biến, có giai điệu dễ nghe, ca từ gần gũi và phù hợp với nhiều lứa tuổi.'],
    ['name' => 'Rock', 'image' => 'rock.jpg', 'description' => 'Nhạc Rock nổi bật với nhịp điệu mạnh mẽ, tiếng guitar điện, trống dồn dập và phong cách cá tính.'],
    ['name' => 'Hip Hop', 'image' => 'hiphop.jpg', 'description' => 'Hip Hop là thể loại nhạc đường phố kết hợp giữa rap, beatbox và nhảy, thể hiện cái tôi cá nhân.'],
    ['name' => 'R&B', 'image' => 'rnb.jpg', 'description' => 'R&B (Rhythm and Blues) mang giai điệu nhẹ nhàng, du dương, thường nói về tình yêu và cảm xúc.'],
    ['name' => 'Rap', 'image' => 'rap.jpg', 'description' => 'Rap là hình thức nhạc nói có nhịp điệu nhanh, được sử dụng để kể chuyện, phản ánh xã hội.'],
    ['name' => 'Jazz', 'image' => 'jazz.jpg', 'description' => 'Jazz là dòng nhạc ngẫu hứng, phức tạp và sâu sắc, thường sử dụng kèn saxophone, piano, contrabass.'],
    ['name' => 'Blues', 'image' => 'blues.jpg', 'description' => 'Blues thể hiện cảm xúc buồn, hoài niệm với giai điệu chậm rãi và giàu tâm trạng.'],
    ['name' => 'Nhạc Trẻ', 'image' => 'nhactre.jpg', 'description' => 'Nhạc Trẻ là các ca khúc hiện đại, được giới trẻ yêu thích với nội dung trẻ trung, năng động.'],
    ['name' => 'Nhạc Vàng', 'image' => 'nhacvang.jpg', 'description' => 'Nhạc Vàng là dòng nhạc trữ tình xưa với ca từ sâu lắng, thường nói về tình yêu, quê hương.'],
    ['name' => 'Nhạc Trịnh', 'image' => 'nhactrinh.jpg', 'description' => 'Nhạc Trịnh là dòng nhạc của nhạc sĩ Trịnh Công Sơn, mang tính triết lý và nhiều suy tư.'],
    ['name' => 'Nhạc Thiếu Nhi', 'image' => 'thieunhi.jpg', 'description' => 'Nhạc Thiếu Nhi là các bài hát vui tươi, giáo dục dành cho trẻ em, dễ hát và dễ nhớ.'],
    ['name' => 'Nhạc Không Lời', 'image' => 'khongloi.jpg', 'description' => 'Nhạc Không Lời là những bản nhạc không có lời ca, giúp thư giãn, tập trung hoặc dùng làm nền.'],
    ['name' => 'Ballad', 'image' => 'ballad.jpg', 'description' => 'Ballad là thể loại nhạc trữ tình, chậm rãi, tập trung vào cảm xúc và chất giọng của ca sĩ.'],
    ['name' => 'EDM', 'image' => 'edm.jpg', 'description' => 'EDM (Electronic Dance Music) là dòng nhạc điện tử sôi động, thường xuất hiện trong lễ hội, vũ trường.'],
    ['name' => 'Dance', 'image' => 'dance.jpg', 'description' => 'Dance là nhạc nhảy với tiết tấu nhanh, mạnh mẽ, thường đi kèm với vũ đạo đẹp mắt.'],
    ['name' => 'Trance', 'image' => 'trance.jpg', 'description' => 'Trance là dòng nhạc điện tử với âm thanh bay bổng, thường kéo dài và lặp lại tạo cảm giác mê hoặc.'],
    ['name' => 'House', 'image' => 'house.jpg', 'description' => 'House là thể loại nhạc điện tử có nhịp nhanh và bass sâu, rất phổ biến trong các club.'],
    ['name' => 'Techno', 'image' => 'techno.jpg', 'description' => 'Techno là nhạc điện tử với nhịp điệu đều đặn, âm thanh mạnh, thường dùng trong rave party.'],
    ['name' => 'Nhạc Phim', 'image' => 'soundtrack.jpg', 'description' => 'Nhạc Phim là các bản nhạc được sử dụng trong phim để tạo cảm xúc cho cảnh quay.'],
    ['name' => 'Cổ Điển', 'image' => 'classical.jpg', 'description' => 'Nhạc Cổ Điển là các tác phẩm âm nhạc bác học, được viết bởi các nhạc sĩ như Beethoven, Mozart.'],
    ['name' => 'Bolero', 'image' => 'bolero.jpg', 'description' => 'Bolero là dòng nhạc trữ tình nổi tiếng, giai điệu chậm và lời ca sâu sắc, dễ đi vào lòng người.'],
    ['name' => 'Country', 'image' => 'country.jpg', 'description' => 'Country là nhạc đồng quê Mỹ với tiếng guitar mộc mạc, gắn liền với cuộc sống nông thôn.'],
    ['name' => 'Reggae', 'image' => 'reggae.jpg', 'description' => 'Reggae có nguồn gốc từ Jamaica, nhịp điệu chậm, thư giãn và mang thông điệp hòa bình.'],
    ['name' => 'Indie', 'image' => 'indie.jpg', 'description' => 'Indie là thể loại không phụ thuộc vào hãng lớn, mang phong cách sáng tạo, tự do cá nhân.'],
    ['name' => 'Folk', 'image' => 'folk.jpg', 'description' => 'Folk là nhạc dân gian, gắn với văn hóa truyền thống và những câu chuyện đời thường.'],
    ['name' => 'Nhạc Cách Mạng', 'image' => 'cachmang.jpg', 'description' => 'Nhạc Cách Mạng là dòng nhạc truyền thống, khơi gợi lòng yêu nước và tự hào dân tộc.'],
    ['name' => 'Nhạc Hòa Tấu', 'image' => 'hoatau.jpg', 'description' => 'Nhạc Hòa Tấu là bản phối khí không lời giữa các nhạc cụ, giúp thư giãn và thưởng thức tinh tế.'],
    ['name' => 'Nhạc Xuân', 'image' => 'xuan.jpg', 'description' => 'Nhạc Xuân là những ca khúc vui tươi, rộn ràng thường được phát vào dịp Tết.'],
    ['name' => 'Nhạc Noel', 'image' => 'noel.jpg', 'description' => 'Nhạc Noel là các bản nhạc Giáng Sinh quen thuộc, tạo không khí an lành và ấm áp.'],
    ['name' => 'Nhạc Thiền', 'image' => 'thien.jpg', 'description' => 'Nhạc Thiền là dòng nhạc nhẹ nhàng, thư thái, dùng để tịnh tâm, tập yoga hoặc thiền định.'],
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
                'description' => $item['description'],
                'status' =>  1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $categories);

        DB::table('categories')->insert($data);
    }
}