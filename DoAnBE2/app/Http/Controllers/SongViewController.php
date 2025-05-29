<?php


namespace App\Http\Controllers;

use App\Models\Song; // Đảm bảo bạn đã import model Song
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Để ghi log gỡ lỗi

class SongViewController extends Controller
{
    public function incrementView(Request $request, Song $song) // Laravel tự động inject Song model
    {
        Log::info('incrementView: Bắt đầu xử lý cho Song ID: ' . $song->id);

        try {
            // Tăng lượt xem cho bài hát
            // Nếu songView chưa tồn tại, nó sẽ được tạo
            $song->songView()->firstOrCreate([])->increment('views');

            Log::info('incrementView: Tăng lượt xem thành công cho Song ID: ' . $song->id);
            return response()->json([
                'success' => true,
                'views' => $song->songView->views // Trả về số lượt xem mới
            ]);
        } catch (\Exception $e) {
            Log::error('incrementView: Lỗi khi tăng lượt xem cho Song ID ' . $song->id . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Could not increment view: ' . $e->getMessage()
            ], 500); // Trả về lỗi 500 nếu có vấn đề
        }
    }
}