<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListeningHistory;
use Illuminate\Support\Facades\Auth;

class ListeningHistoryController extends Controller
{
    public function index()
    {
// Lấy user_id của người dùng đang đăng nhập
        $userId = Auth::id();

// Lấy lịch sử nghe nhạc từ bảng listening_history của người dùng
        $listeningHistory = ListeningHistory::with('song.artist', 'song.category')
            ->where('user_id', $userId)  // Lọc theo user_id
            ->orderBy('listened_at', 'desc') // Sắp xếp theo thời gian nghe
            ->paginate(10); // Phân trang, mỗi trang hiển thị 10 bài hát

        return view('frontend.listening_history', compact('listeningHistory'));
    }

    public function save(Request $request)
    {
        $songId = $request->song_id;
        $userId = Auth::id();

        if (!$songId || !$userId) {
            return response()->json(['success' => false, 'message' => 'Invalid data'], 400);
        }

        // Kiểm tra lịch sử đã có bản ghi cho bài hát này chưa
        $existing = ListeningHistory::where('user_id', $userId)
            ->where('song_id', $songId)
            ->first();

        if ($existing) {
            // Nếu có, cập nhật lại thời gian nghe lên mới nhất
            $existing->listened_at = now();
            $existing->save();
        } else {
            // Nếu chưa có, tạo bản ghi mới
            $history = new ListeningHistory();
            $history->user_id = $userId;
            $history->song_id = $songId;
            $history->listened_at = now();
            $history->save();
        }

        return response()->json(['success' => true]);
    }


// Xóa lịch sử
    public function destroy($id)
    {
        $history = ListeningHistory::find($id);
        if ($history) {
            $history->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Not found'], 404);
    }

// Xóa tất cả lịch sử
    public function clearAll()
    {
        ListeningHistory::where('user_id', Auth::id())->delete();
        return response()->json(['success' => true]);
    }
}
