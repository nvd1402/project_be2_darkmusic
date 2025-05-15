<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        $nameAds = [
            'Vinamilk Advertising',
            'Tiki Media',
            'Shopee Ads',
            'Coca-Cola Vietnam',
            'PepsiCo Marketing',
            'VNG Promotion',
            'Samsung Vietnam',
            'Zalo Ads',
            'Yamaha Motor Marketing',
            'Nestlé Việt Nam'
        ];
        $linkAds = [
            'https://www.vinamilk.com.vn/',
            'https://www.tiki.vn/',
            'https://shopee.vn/',
            'https://www.coca-cola.com/vn/',
            'https://www.pepsico.com/',
            'https://vng.com.vn/',
            'https://www.samsung.com/vn/',
            'https://ads.zalo.me/',
            'https://www.yamaha-motor.com.vn/',
            'https://www.nestle.com.vn/'
        ];
        $descriptionAds = [
            'Khuyến mãi mùa hè cực sốc, giảm giá lên đến 50% toàn bộ sản phẩm.',
            'Sữa tươi nguyên chất 100%, giàu dinh dưỡng cho cả gia đình.',
            'Mua 1 tặng 1 cho mọi đơn hàng từ 499K tại Tiki.vn.',
            'Cập nhật xu hướng công nghệ mới nhất cùng Samsung Galaxy.',
            'Shopee sale sinh nhật, miễn phí vận chuyển toàn quốc.',
            'Nạp năng lượng mỗi ngày với nước giải khát mát lạnh từ Pepsi.',
            'Zalo Ads – Giải pháp quảng cáo hiệu quả cho doanh nghiệp Việt.',
            'Mùa hè sôi động cùng Yamaha – Rước xe về nhà, nhận quà liền tay.',
            'Trọn vị ngon, trọn yêu thương với sản phẩm từ Nestlé.',
            'Coca-Cola – Cùng nhau làm nên những khoảnh khắc tuyệt vời.'
        ];

        $imageAds = Storage::disk('public')->files('ads');

        if (empty($imageAds)) {
            $this->command->warn('Không tìm thấy ảnh trong thư mục');
            $imageAds = ['ads/default.jpg'];
        }

        $data = [];

        for ($i = 0; $i < 10; $i++) {
            $randomName = $nameAds[array_rand($nameAds)];
            $randomImage = $imageAds[array_rand($imageAds)];
            $randomLink = $linkAds[array_rand($linkAds)];
            $randomDescription = $descriptionAds[array_rand($descriptionAds)];

            $data[] = [
                'name' => $randomName,
                'media_type' => basename($randomImage),
                'link_url' => $randomLink,
                'is_active' => rand(0, 1),
                'description' => $randomDescription,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('ads')->insert($data);
    }
}
