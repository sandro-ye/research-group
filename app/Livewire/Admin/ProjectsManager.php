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
    ];
    public $projects;
    public $users;
    public $publications;
    public $projectId;
    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $selectedMembers = [];
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

    public function removeEndDate()
    {
        $this->end_date = null;
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    public function loadProjects()
    {
        $this->projects = Project::with(['members'])->latest()->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->start_date;
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $project = Project::with(['members'])->findOrFail($id);

        abort_unless($project->canBeEditedBy(auth()->user()), 403);

        $this->projectId = $project->id;
        $this->title = $project->title;
        $this->description = $project->description;
        $this->start_date = $project->start_date;
        $this->end_date = $project->end_date;

        $this->selectedMembers = $project->members->pluck('id')->toArray();

        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate(
            [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ],
            [
                'end_date.after_or_equal' =>
                    'La data di fine deve essere uguale o successiva alla data di inizio.',
            ]
        );

        // 👥 membri
        $hasTeacher = User::whereIn('id', $this->selectedMembers)
            ->where('role', 'docente')
            ->exists();

        if (!$hasTeacher) {
            $this->addError(
                'selectedMembers',
                'Il progetto deve avere almeno un docente tra i membri.'
            );
            return;
        }

        $project = Project::updateOrCreate(
            ['id' => $this->projectId],
            [
                'title' => $this->title,
                'description' => $this->description,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]
        );

        $project->members()->sync($this->selectedMembers);

        $project->save();

        $this->closeModal();
        $this->loadProjects();
    }

    public function delete()
    {
        $project = Project::findOrFail($this->deleteId);

        abort_unless($project->canBeEditedBy(auth()->user()), 403);

        $project->delete();

        $this->confirmingDelete = false;
        $this->deleteId = null;

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
    }
    public function render()
    {
        return view('livewire.admin.projects-manager')->layout('layouts.app');
    }
}
