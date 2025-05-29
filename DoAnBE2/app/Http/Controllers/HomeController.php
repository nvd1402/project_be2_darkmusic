<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Artist;
use App\Models\favourite; // Đảm bảo favourite model đúng chính tả, thường là Favorite
use Illuminate\Http\Request;
use Illuminate\View\View;
// use function Termwind\renderUsing; // Không cần thiết nếu không sử dụng Termwind
use App\Models\Song;
use App\Models\News;
use App\Models\Category; // Đảm bảo Category model đúng chính tả, thường là Category
use App\Models\SongView; // Import model SongView
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon; // Import Carbon cho việc xử lý thời gian


class HomeController extends Controller
{

    //
    public function index(): View
    {
        $artists = Artist::latest()->paginate(5);
        $ads = Ad::where('is_active', true)->latest()->get();

        //de xuat: ducanh
        $latestSong = Song::with(['artist', 'category'])
            ->orderBy('created_at', 'desc')
            ->first();

        $recommendedSongs = Song::with(['artist', 'category'])
            ->orderBy('created_at', 'desc')
            ->skip(1)
            ->take(4)
            ->get();
        $latestCategories = Category::latest()->take(5)->get(); // Sửa category thành Category
// Lấy bài hát nổi bật được yêu thích nhất (Top Liked Song)
        $topLikedSong = Song::with(['artist', 'category'])
            ->withCount('usersWhoLiked')
            ->orderByDesc('users_who_liked_count')
            ->first(); // Lấy chỉ một bài hát

        //Lấy danh sách các bài hát yêu thích nhiều nhất (Most Liked Songs)
        $mostLikedSongs = Song::with(['artist', 'category'])
            ->withCount('usersWhoLiked')
            ->orderByDesc('users_who_liked_count')
            ->limit(5) // Lấy 5 bài
            ->get();

        return view('frontend.index', compact('ads', 'latestSong', 'recommendedSongs', 'artists', 'latestCategories','topLikedSong',
            'mostLikedSongs'));
    }


    public function song(string $slug): View
    {
        // Bạn có thể muốn tìm bài hát cụ thể theo slug ở đây
        // Ví dụ: $song = Song::where('slug', $slug)->firstOrFail();
        // Sau đó truyền $song này vào view
        $songs = Song::all(); // Hiện tại vẫn lấy tất cả bài hát
        return view('frontend.song', [
            'songs' => $songs,
        ]);
    }

    public function rankings(): View
    {
        // Lấy tất cả bài hát và LEFT JOIN với bảng song_views
        // Điều này đảm bảo tất cả bài hát đều được hiển thị, kể cả những bài chưa có lượt xem
        $rankedSongs = Song::leftJoin('song_views', 'songs.id', '=', 'song_views.song_id')
            ->select(
                'songs.*', // Lấy tất cả các cột từ bảng songs
                'song_views.views as luot_xem' // Lấy cột 'views' từ song_views và đặt tên là 'luot_xem'
            )
            // Sử dụng with(['artist', 'category']) để eager load quan hệ
            ->with(['artist', 'category'])
            // Sắp xếp theo lượt xem giảm dần (bài có lượt xem cao hơn lên trước)
            // Nếu lượt xem bằng nhau (hoặc cả hai đều null/0), thì sắp xếp theo created_at giảm dần (bài mới hơn lên trước)
            ->orderByDesc('luot_xem')
            ->orderByDesc('songs.created_at') // Quan trọng: chỉ định rõ created_at của bảng songs
            ->limit(10) // Giới hạn chỉ lấy 10 bài cho BXH (như trong layout của bạn)
            ->get();

        return view('frontend.rankings', compact('rankedSongs')); // Truyền dữ liệu sang view frontend.rankings
    }

    public function news(): View
    {
        $news = News::all();
        return view('frontend.news', compact('news'));
    }

    public function category(): View
    {
        $nhoms = ['Nhạc Rock', 'Nhạc Remix', 'Nhạc Nổi Bật', 'Nhạc Mới'];
        $categoriesByNhom = [];

        foreach ($nhoms as $nhom) {
            $categoriesByNhom[$nhom] = Category::where('nhom', $nhom)->get();
        }

        return view('frontend.category', compact('nhoms', 'categoriesByNhom'));
    }
    public function categoryDetail(string $tentheloai)
    {
        // Tìm thể loại theo tentheloai
        $category = Category::where('tentheloai', $tentheloai)->first();

        if (!$category) {
            abort(404, 'Không tìm thấy thể loại');
        }

        // Truyền $category sang view, chỉ cần lấy đúng thể loại này thôi
        return view('frontend.category_show', compact('category'));
    }
    public function favorite(): View
    {
        if (Auth::check()) {
            $favorites = favourite::where('user_id', Auth::id())
                ->with('Song.Artist') // LƯU Ý: Đây là 'Song.Artist'
                ->get();
        } else {
            $favorites = collect();
        }
        return view('frontend.favorite',compact('favorites'));
    }
    public function destroy(string $id)
    {
        try {
            $favourite = favourite::findOrFail($id);

            // Kiểm tra quyền sở hữu
            if ($favourite->user_id !== Auth::id()) {
                return redirect()->back()->with('error', 'Bạn không có quyền xóa mục yêu thích này.');
            }
            $favourite->delete();

            return redirect()->route('frontend.favorite')->with('success', 'Bài hát đã được xóa khỏi danh sách yêu thích.');

        } catch (ModelNotFoundException $e) {
            return redirect()->route('frontend.favorite')
                ->with('info', 'Bài hát này đã được xóa hoặc không còn tồn tại.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không mong muốn khi xóa bài hát. Vui lòng thử lại.');
        }
    }

    // Phương thức tăng lượt xem khi một bài hát được phát
    public function incrementSongView(Request $request, $songId)
    {
        // Tìm bài hát
        $song = Song::find($songId);

        if (!$song) {
            return response()->json(['error' => 'Bài hát không tồn tại'], 404);
        }

        // Tăng lượt xem trong bảng song_views
        // findOrCreate sẽ tìm bản ghi nếu có, nếu không thì tạo mới
        $songView = SongView::firstOrCreate(
            ['song_id' => $songId],
            ['views' => 0] // Giá trị mặc định nếu tạo mới
        );
        $songView->increment('views'); // Tăng lượt xem lên 1

        return response()->json(['message' => 'Lượt xem đã được cập nhật', 'views' => $songView->views]);
    }
}
