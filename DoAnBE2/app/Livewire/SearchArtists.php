<?php

namespace App\Livewire;

use App\Models\Artist;
use Livewire\Component;
use Livewire\WithPagination;

class SearchArtists extends Component
{
    use WithPagination;
    public $query = '';

    public function updatingQuery()
    {
        $this->resetPage();
    }

    public function render()
    {
        $artists = [];

<<<<<<< HEAD
        if (strlen($this->query) > 0) {
            $artists = Artist::where('name_artist', 'like', '%' . $this->query . '%')
                ->orWhereHas('category', function ($q) {
                    $q->where('tentheloai', 'like', '%' . $this->query . '%');
                })
                ->paginate(10);
=======
        $trimmedQuery = trim($this->query);

        if (strlen($trimmedQuery) > 0) {
            $artists = Artist::where('name_artist', 'like', '%' . $trimmedQuery . '%')->get();
>>>>>>> admin/ads-darkmusic
        } else {
            $artists = Artist::paginate(10);
        }

        return view('livewire.search-artists', compact('artists'));
    }
}
