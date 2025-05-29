<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Artist;
use App\Models\favourite;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function Termwind\renderUsing;
use App\Models\Song;
use App\Models\News;
use App\Models\category;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\ModelNotFoundException;





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
        $latestCategories = category::latest()->take(5)->get();
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
        $songs = Song::all();
        return view('frontend.song', [
            'songs' => $songs,
        ]);
    }

    public function rankings(): View
    {
        return view('frontend.rankings');
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
        $category = category::where('tentheloai', $tentheloai)->first();

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
}
