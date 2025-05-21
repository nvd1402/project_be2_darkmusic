<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
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
        // Lấy bài hát mới nhất
        $trending = Song::latest('created_at')->first();

        // Lấy 10 bài hát mới nhất làm “Top Songs”
        $topSongs = Song::latest('created_at')->limit(10)->get();

        // Lấy genres
        $categories = Category::orderBy('id', 'asc')
            ->take(5)
            ->get();

        $ads = Ad::where('is_active', true)->latest()->get();
        return view('frontend.index', compact('trending', 'topSongs', 'categories', 'ads'));
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
    $categories = Category::all();// Lấy danh sách thể loại
    return view('frontend.category', compact('categories'));
}

}
