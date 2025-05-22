<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListeningHistory; // Import model ListeningHistory
use App\Models\User; // Import model User
use App\Models\Song;
use App\Models\Artist;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ListeningHistoryController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {

            return redirect('/login')->with('error', 'Bạn cần đăng nhập để xem lịch sử nghe nhạc.');
        }

        $user = Auth::user();

        $listeningHistory = ListeningHistory::where('user_id', $user->user_id)
            ->with([
                'song' => function($query) {
                    $query->select('id', 'title', 'artist_id', 'category_id', 'thumbnail');
                },
                'song.artist' => function($query) {
                    $query->select('id', 'name_artist'); // Tên cột nghệ sĩ trong bảng artists
                },
                'song.category' => function($query) {
                    $query->select('id', 'tentheloai'); // Tên cột thể loại trong bảng categories
                }
            ])
            ->orderByDesc('listened_at')
            ->paginate(10); // Phân trang 10 item mỗi trang

        // Debug: Bạn có thể bỏ comment dòng này để kiểm tra dữ liệu trước khi render view
        // dd($listeningHistory->toArray());

        return view('frontend.history', compact('listeningHistory')); // <== SỬA TÊN VIEW TỪ 'ListeningHistory' thành 'history' (chữ h thường) // Truyền biến $listeningHistory vào view
    }
}
