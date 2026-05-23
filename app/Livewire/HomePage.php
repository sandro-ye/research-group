<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Publication;
use App\Models\Announcement;
use Livewire\Component;

class HomePage extends Component
{
    public $publications = [];

    public $projects = [];

    public function mount()
    {
        $this->publications = Publication::latest()->take(3)->get();

        $this->projects = Project::latest()->get();
    }

    public function getActiveProjectsProperty()
    {
        return Project::with('members')->whereNull('end_date')->get();
    }
    
    public function getAnnouncementsProperty()
    {
        return Announcement::where('is_active', true)->latest()->take(5)->get();
    }

    public function render()
    {
        return view('livewire.home-page')->layout('layouts.guest');
    }
}
