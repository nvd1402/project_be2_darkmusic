<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {


              // Tắt kiểm tra khóa ngoại để truncate bảng
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    DB::table('comments')->truncate();

    // Bật lại kiểm tra khóa ngoại
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
        // Giả sử bạn đã có user_id và news_id hợp lệ
        // Tạo 10 comment mẫu
        for ($i = 1; $i <= 10; $i++) {
            DB::table('comments')->insert([
                'user_id' => rand(1, 5),      // giả sử user_id từ 1 đến 5
                'news_id' => rand(1, 5),      // giả sử news_id từ 1 đến 5
                'noidung' => 'Đây là bình luận mẫu số ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}