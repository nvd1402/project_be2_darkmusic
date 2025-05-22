<?php

namespace App\Http\Controllers;

use App\Models\Ad;
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


        return view('frontend.index', compact('ads', 'latestSong', 'recommendedSongs'));
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
