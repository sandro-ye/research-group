<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;

class ProjectDetailPage extends Component
{
    public Project $project;

    public function mount(Project $project)
    {
        $this->project = Project::with(['members', 'publications.authors'])->findOrFail($project->id);
    }

    public function getIsActiveProperty()
    {
        return is_null($this->project->end_date);
    }
    public function render()
    {
        return view('livewire.project-detail-page')->layout('layouts.app');
    }
}
