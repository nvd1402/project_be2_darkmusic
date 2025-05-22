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
            'Giải thưởng âm nhạc quốc tế vinh danh nghệ sĩ Việt',
            'Sân khấu ngoài trời bùng nổ với âm nhạc điện tử',
            'Fan xếp hàng dài chờ thần tượng xuất hiện',
            'Liveshow của Mỹ Tâm cháy vé sau 5 phút',
            'Thị trường nhạc số Việt Nam đang bùng nổ',
            'Thế hệ nghệ sĩ Gen Z khuấy đảo làng nhạc Việt'
        ];

        $units = ['Báo Tuổi Trẻ', 'Zing News', 'VNExpress', 'Dân Trí', 'Thanh Niên', 'Kenh14', 'Yan News'];

        $images = [
            'news1.jpg',
            'news2.jpg',
            'news3.jpg',
            'news4.jpg',
            'news5.jpg',
            'news6.jpg',
            'news7.jpg',
        ];

        // Mẫu nội dung (ngắn hơn 1000 chữ chút xíu để tránh quá dài, nhưng vẫn rất chi tiết)
$paragraphs = [
    'Sự kiện âm nhạc năm nay thu hút đông đảo người tham gia với sự xuất hiện của nhiều nghệ sĩ tên tuổi trong và ngoài nước. Từ chiều sớm, dòng người đã bắt đầu tấp nập đổ về khu vực sân khấu chính, tạo nên một không khí náo nhiệt, sôi động chưa từng có. Các fan hâm mộ mang theo băng rôn, poster và các vật phẩm để cổ vũ thần tượng của mình. Không khí rộn ràng, phấn khích lan tỏa khắp mọi nơi, hứa hẹn một đêm nhạc đầy cảm xúc và mãn nhãn.',
    
    'Không khí lễ hội sôi động được tạo nên bởi những màn trình diễn đầy màu sắc và nhiệt huyết đến từ các nhóm nhạc trẻ đang lên như một làn gió mới thổi vào làng nhạc Việt Nam. Khu vực check-in với các backdrop hoành tráng và gian hàng ẩm thực luôn chật kín người, nơi mọi người vừa có thể thưởng thức những món ăn đặc sắc vừa giao lưu, kết nối với nhau. Sự kiện còn được tổ chức thêm các trò chơi tương tác để khán giả có thêm trải nghiệm vui vẻ và ý nghĩa.',
    
    'Những bản hit đình đám được vang lên, khiến hàng ngàn khán giả không thể ngồi yên. Mọi người cùng nhau hòa giọng, nhún nhảy theo từng nhịp điệu sôi động, tạo nên bầu không khí cuồng nhiệt và đầy sức sống. Mỗi tiết mục đều được dàn dựng công phu với những điệu nhảy đẹp mắt, trang phục bắt mắt, khiến khán giả như bị cuốn vào một thế giới âm nhạc huyền ảo và đầy cảm xúc.',
    
    'Ban tổ chức đã đầu tư rất lớn cho hệ thống âm thanh và ánh sáng hiện đại, mang lại trải nghiệm thị giác và thính giác hoàn hảo cho khán giả. Hệ thống LED siêu khủng bao phủ toàn bộ sân khấu, kết hợp với các hiệu ứng laser và pháo hoa tạo nên một cảnh tượng hoành tráng, lộng lẫy chưa từng thấy. Điều này không chỉ nâng tầm sự kiện mà còn khiến người xem cảm thấy mãn nhãn và khó quên.',
    
    'Sự kiện không chỉ là nơi thưởng thức âm nhạc mà còn lan tỏa tinh thần kết nối cộng đồng và hỗ trợ từ thiện vô cùng ý nghĩa. Ban tổ chức đã phối hợp với nhiều tổ chức xã hội để gây quỹ giúp đỡ trẻ em nghèo, các hoàn cảnh khó khăn trong xã hội. Mỗi vé mua được đều góp phần vào các hoạt động nhân đạo này, khiến sự kiện mang thêm giá trị nhân văn sâu sắc bên cạnh mục đích giải trí thuần túy.',
    
    'Các nghệ sĩ trẻ tài năng đã có cơ hội thể hiện bản thân trước hàng ngàn khán giả yêu âm nhạc. Nhiều tài năng triển vọng nhận được sự chú ý lớn từ công chúng và các nhà sản xuất âm nhạc. Họ mang đến những màn trình diễn đầy sáng tạo, phá cách và cuốn hút, mở ra tương lai rực rỡ cho nền âm nhạc Việt Nam trong thời đại mới. Đây cũng là dịp để họ giao lưu, học hỏi và trau dồi kỹ năng từ các nghệ sĩ kỳ cựu.',
    
    'Ngoài các màn biểu diễn, sự kiện còn tổ chức nhiều hoạt động hấp dẫn như talkshow chuyên đề, chia sẻ kinh nghiệm sáng tác và sản xuất âm nhạc cùng các producer nổi tiếng trong và ngoài nước. Khán giả có thể đặt câu hỏi, học hỏi từ những người trong nghề, đồng thời khám phá những xu hướng mới nhất trong âm nhạc hiện đại. Điều này tạo nên một sân chơi bổ ích, giúp mọi người phát triển kỹ năng và kết nối chặt chẽ hơn với ngành công nghiệp giải trí.',
    
    'Một điểm nhấn thú vị của sự kiện là khu trưng bày nhạc cụ truyền thống Việt Nam, với các loại đàn tranh, đàn bầu, sáo trúc cùng những câu chuyện văn hóa đặc sắc được các nghệ nhân lão luyện giới thiệu. Hoạt động này giúp thế hệ trẻ hiểu và trân trọng hơn bản sắc văn hóa âm nhạc dân tộc, đồng thời khơi gợi niềm tự hào và trách nhiệm bảo tồn những giá trị quý báu của ông cha để lại.',
    
    'Các đơn vị truyền thông lớn như Báo Tuổi Trẻ, VNExpress, Zing News và nhiều trang mạng xã hội cũng có mặt đưa tin liên tục về sự kiện, tạo nên sức lan tỏa mạnh mẽ trên các nền tảng trực tuyến. Các video, hình ảnh, bình luận nhanh chóng được chia sẻ rộng rãi, thu hút sự quan tâm của hàng triệu lượt xem và tương tác, góp phần quảng bá văn hóa âm nhạc Việt Nam ra thế giới.',
    
    'Sự kiện kết thúc bằng màn pháo hoa rực rỡ kéo dài hàng chục phút, thắp sáng bầu trời đêm và để lại nhiều ấn tượng sâu sắc trong lòng người tham dự. Nhiều khán giả chia sẻ cảm xúc hạnh phúc, phấn khởi và hy vọng sự kiện sẽ được tổ chức định kỳ hàng năm, trở thành một dấu mốc quan trọng trên bản đồ âm nhạc Việt Nam. Đây thực sự là một lễ hội âm nhạc không thể bỏ qua đối với mọi tín đồ yêu nghệ thuật.'
];


        for ($i = 1; $i <= 100; $i++) {
            // Ghép random 6 đoạn thành nội dung dài tương đương ~1000 chữ
            shuffle($paragraphs);
            $content = 'Đây là nội dung tin tức mẫu số ' . $i . '. ' . implode("\n\n", array_slice($paragraphs, 0, 6));

            DB::table('news')->insert([
                'tieude' => $titles[array_rand($titles)],
                'noidung' => $content,
                'donvidang' => $units[array_rand($units)],
                'hinhanh' => $images[array_rand($images)],
                'created_at' => now()->subDays(rand(0, 365))->subMinutes(rand(0, 1440)), // Random trong 1 năm gần nhất
                'updated_at' => now(),
            ]);
        }
    }
}
