<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function Termwind\renderUsing;
use App\Models\Song;

class HomeController extends Controller
{
    //
    public function index(): View
    {
        $ads = Ad::where('is_active', true)->latest()->get();
        return view('frontend.index', compact('ads'));
    }
    public function category(string $slug): View
    {
        return view('frontend.category', ['slug' => $slug]);
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
}
