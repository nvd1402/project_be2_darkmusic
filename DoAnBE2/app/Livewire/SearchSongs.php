<?php

namespace App\Livewire;
use App\Models\Artist;
use App\Models\Song;
use Livewire\Component;
use Livewire\WithPagination;

class SearchSongs extends Component
{
    use WithPagination;
    public $query = '';
    public function updatedQuery()
    {
        $this->resetPage();
    }
    public function render()
    {
        $songsQuery = Song::query();
        if (strlen($this->query) > 0) {
            $songsQuery->where('tenbaihat', 'like', '%' . $this->query . '%');
        }
        $songs = $songsQuery->paginate(5);

        return view('livewire.search-songs', compact('songs'));
    }
}
