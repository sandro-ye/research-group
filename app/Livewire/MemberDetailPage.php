<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class MemberDetailPage extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user->load(['publications.authors', 'projects']);
    }

    public function getActiveProjectsProperty()
    {
        return $this->user->projects->whereNull('end_date');
    }

    public function getCompletedProjectsProperty()
    {
        return $this->user->projects->whereNotNull('end_date');
    }

    public function render()
    {
        return view('livewire.member-detail-page')->layout('layouts.guest');
    }
}
