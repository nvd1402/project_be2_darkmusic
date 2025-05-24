<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        // Tắt kiểm tra khóa ngoại để truncate bảng
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Xóa dữ liệu cũ trong bảng comments
        DB::table('comments')->truncate();

        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create();

        // Mảng câu comment mẫu đa dạng, ý nghĩa
        $commentsSamples = [
            "Bài viết rất hữu ích, cảm ơn bạn đã chia sẻ!",
            "Tôi rất thích nội dung này, mong bạn sẽ tiếp tục cập nhật thêm.",
            "Thông tin chi tiết và dễ hiểu, tuyệt vời!",
            "Bình luận của bạn thật sâu sắc, tôi học được nhiều điều.",
            "Rất mong chờ những bài viết tiếp theo của bạn.",
            "Mình có một vài góp ý nhỏ để bài viết hoàn thiện hơn.",
            "Nội dung rất thú vị và hấp dẫn, cám ơn bạn!",
            "Cảm ơn bạn đã chia sẻ thông tin quý giá này.",
            "Bài viết đầy đủ, chi tiết và dễ hiểu.",
            "Rất tuyệt vời, hy vọng bạn tiếp tục phát triển nhé!"
        ];

     
        for ($i = 1; $i <= 40; $i++) {
            DB::table('comments')->insert([
                'user_id' => rand(1, 30),      // giả sử user_id từ 1 đến 5
                'news_id' => rand(1, 30),      // giả sử news_id từ 1 đến 5
                'noidung' => $commentsSamples[array_rand($commentsSamples)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
