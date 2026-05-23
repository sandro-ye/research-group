<?php

namespace App\Livewire;

use App\Models\Announcement;
use Livewire\Component;
use App\Models\User;
use App\Models\Publication;
use App\Models\Project;

class AdminDashboard extends Component
{
    public $usersCount;
    public $publicationsCount;
    public $projectsCount;
    public $announcementsCount;

    public function mount()
    {
        $this->usersCount = User::count();
        $this->publicationsCount = Publication::count();
        $this->projectsCount = Project::count();
        $this->announcementsCount = Announcement::count();
    }
    public function render()
    {
        return view('livewire.admin-dashboard')->layout('layouts.app');
    }
}
