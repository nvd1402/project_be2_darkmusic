<?php

namespace App\Livewire;

use App\Models\Ad;
use Livewire\Component;

class SearchAds extends Component
{
    public $query = '';
    public $state = '';

    public function render()
    {
        $ads = [];

        if (!empty($this->query)) {
            $ads = Ad::where('name', 'like', '%' . $this->query . "%")
                ->orWhere('description', 'like', '%' . $this->query . "%")
                ->get();
        } else {
            $ads = Ad::latest()->paginate(10);
        }

        if ($this->state !== '') {
            $ads = Ad::where('is_active', $this->state)->get();
        }

        if ($this->state === 'all') {
            $ads = Ad::latest()->paginate(10);
        }

        return view('livewire.search-ads', compact('ads'));
    }
}
