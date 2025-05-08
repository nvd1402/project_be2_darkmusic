<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use function Termwind\renderUsing;

class HomeController extends Controller
{
    //
    public function index():View
    {
        return view('frontend.index');
    }
    public function category(string $slug): View
    {
        return view('frontend.category', ['slug' => $slug]);
    }

    public function song(string $slug): View
    {
        return view('frontend.song');
    }

    public function rankings(): View
    {
        return view('frontend.rankings');
    }
}
