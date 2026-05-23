<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class MembersPage extends Component
{
    
    public $members = [];

    public function mount()
    {
        // Dati fittizi (poi DB)
        $this->members = User::all();
    }

    public function render()
    {
        return view('livewire.members-page')->layout('layouts.guest');
    }
}
