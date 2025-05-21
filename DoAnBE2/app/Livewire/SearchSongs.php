<?php

namespace App\Livewire;

use App\Models\Song;
use Livewire\Component;

class SearchSongs extends Component
{
    public $query = '';
    public function render()
    {
        $songs = [];

        if (strlen($this->query) > 0) {
            $songs = Song::where('tenbaihat', 'like', '%' . $this->query . '%')->get();
        } else {
            $songs = song::all();
        }
        return view('livewire.search-songs', compact('songs'));
    }
}
