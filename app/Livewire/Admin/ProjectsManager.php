<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Project;
use App\Models\User;
use App\Models\Publication;

class ProjectsManager extends Component
{
    protected $listeners = [
        'editProject' => 'edit',
        'deleteProject' => 'confirmDelete',
    ]
    ;
    public $projects;
    public $users;
    public $publications;

    public $projectId;
    public $title;
    public $description;
    public $start_date;
    public $end_date;

    public $selectedMembers = [];
    public $selectedPublication = null;

    public $isOpen = false;
    public $confirmingDelete = false;
    public $deleteId = null;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ];

    public function mount()
    {
        $this->loadProjects();
        $this->users = User::all();
        $this->publications = Publication::all();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    public function loadProjects()
    {
        $this->projects = Project::with(['members', 'publication'])->latest()->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->start_date;
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $project = Project::with(['members', 'publication'])->findOrFail($id);

        abort_unless($project->canBeEditedBy(auth()->user()), 403);

        $this->projectId = $project->id;
        $this->title = $project->title;
        $this->description = $project->description;
        $this->start_date = $project->start_date;
        $this->end_date = $project->end_date;

        $this->selectedMembers = $project->members->pluck('id')->toArray();
        $this->selectedPublication = $project->publication_id;

        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate();

        $project = Project::updateOrCreate(
            ['id' => $this->projectId],
            [
                'title' => $this->title,
                'description' => $this->description,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]
        );

        // 👥 membri
        $project->members()->sync($this->selectedMembers);

        // 📄 pubblicazione (solo se concluso)
        if ($project->isCompleted() && $this->selectedPublication) {
            $project->assignPublication($this->selectedPublication);
        } else {
            $project->publication_id = null;
            $project->save();
        }

        $this->closeModal();
        $this->loadProjects();
    }

    public function delete($id)
    {
        $project = Project::findOrFail($id);

        abort_unless($project->canBeEditedBy(auth()->user()), 403);

        $this->confirmingDelete = false;
        $this->deleteId = null;

        $project->delete();

        $this->loadProjects();
        session()->flash('success', 'Progetto eliminato');
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->isOpen = false;
    }

    public function openModal()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    private function resetForm()
    {
        $this->projectId = null;
        $this->title = '';
        $this->description = '';
        $this->start_date = null;
        $this->end_date = null;
        $this->selectedMembers = [];
        $this->selectedPublication = null;
    }
    public function render()
    {
        return view('livewire.admin.projects-manager')->layout('layouts.app');
    }
}
