<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Publication;

class PublicationsPage extends Component
{
    public $search = '';
    public $year = '';
    public $publications = [];

    public function mount()
    {
        //$this->publications = \App\Models\Publication::all()->toArray();
        $this->publications = Publication::all()->toArray();
    }

    public function resetParameters()
    {
        $this->search = '';
        $this->year = '';
    }
    
    public function getFilteredPublicationsProperty()
    {
        return Publication::with('authors')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->year, function ($query) {
                $query->where('year', $this->year);
            })
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.publications-page')->layout('layouts.guest');
    }
}
