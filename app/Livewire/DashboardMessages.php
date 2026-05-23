<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Message;

class DashboardMessages extends Component
{
    public $content;
    public $project_id;
    public $filteredProjectId = null;

    protected $rules = [
        'content' => 'required|string|max:1000',
        'project_id' => 'nullable|exists:projects,id',
    ];

    public function getProjectsProperty()
    {
        $user = auth()->user();

        return $user->isAdmin()
            ? Project::all()
            : $user->projects;
    }

    public function getMessagesProperty()
    {
        if($this->filteredProjectId) {
            $allowedProjectIds = $this->projects->pluck('id')->toArray();

            abort_unless(in_array($this->filteredProjectId, $allowedProjectIds), 403);
        }

        $query = Message::with(['user', 'project'])
            ->latest();

        $user = auth()->user();

        $allowedProjectIds = $user->isAdmin()
            ? Project::pluck('id')->toArray()
            : $user->projects->pluck('id')->toArray();

        if (!$this->filteredProjectId) {
            $query->where(function ($q) use ($allowedProjectIds) {
                $q->whereNull('project_id')
                  ->orWhereIn('project_id', $allowedProjectIds);
            });
        } else {
            abort_unless(
                in_array($this->filteredProjectId, $allowedProjectIds),
                403
            );

            $query->where('project_id', $this->filteredProjectId);
        }

        return $query->get();
    }

    public function send()
    {
        $this->validate();

        if ($this->project_id) {
            $project = Project::find($this->project_id);

            abort_unless(
                $project->members->contains(auth()->id()) || auth()->user()->isAdmin(),
                403
            );
        }

        Message::create([
            'user_id' => auth()->id(),
            'project_id' => $this->project_id,
            'content' => $this->content,
        ]);

        $this->reset(['content', 'project_id']);
    }
    public function render()
    {
        return view('livewire.dashboard-messages');
    }
}
