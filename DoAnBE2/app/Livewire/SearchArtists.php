<?php

namespace App\Livewire;

use App\Models\Artist;
use Livewire\Component;
use Livewire\WithPagination;

class SearchArtists extends Component
{
    use WithPagination;

    public $query = '';

    protected $updatesQueryString = ['query'];

    public function updatingQuery()
    {
        $this->resetPage(); // reset về page 1 khi query thay đổi
    }

    public function render()
    {
        $trimmedQuery = trim($this->query);

        $artists = Artist::with('category')
            ->when($trimmedQuery, function ($query) use ($trimmedQuery) {
                $query->where('name_artist', 'like', "%{$trimmedQuery}%")
                    ->orWhereHas('category', function ($q) use ($trimmedQuery) {
                        $q->where('tentheloai', 'like', "%{$trimmedQuery}%");
                    });
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.search-artists', compact('artists'));
    }
}
