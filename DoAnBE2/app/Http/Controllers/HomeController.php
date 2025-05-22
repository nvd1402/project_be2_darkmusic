<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function Termwind\renderUsing;
use App\Models\Song;
use App\Models\News;
use App\Models\category;



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


        return view('frontend.index', compact('ads', 'latestSong', 'recommendedSongs', 'artists'));
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
}
