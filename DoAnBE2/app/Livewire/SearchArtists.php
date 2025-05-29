<?php

namespace App\Livewire;

use App\Models\Artist;
use Livewire\Component;
use Livewire\WithPagination;

class SearchArtists extends Component
{
    public $query = '';

    public function render()
    {
        $artists = [];

        $trimmedQuery = trim($this->query);

        if (strlen($trimmedQuery) > 0) {
            $artists = Artist::where('name_artist', 'like', '%' . $trimmedQuery . '%')
                ->orWhereHas('category', function ($q) {
                    $q->where('tentheloai', 'like', '%' . $this->query . '%');
                })
                ->get();
        } else {
            $artists =  Artist::paginate(10);
        }
        return view('livewire.search-artists', compact('artists'));
    }
}
