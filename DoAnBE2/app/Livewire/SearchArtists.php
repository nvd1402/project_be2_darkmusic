<?php

namespace App\Livewire;

use App\Models\Artist;
use Livewire\Component;

class SearchArtists extends Component
{
    public $query = '';

    public function render()
    {
        $artists = [];

        if (strlen($this->query) > 0) {
            $artists = Artist::where('name_artist', 'like', '%' . $this->query . '%')->get();
        } else {
            $artists = Artist::paginate(10);
        }

        return view('livewire.search-artists', compact('artists'));
    }
}
