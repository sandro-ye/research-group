<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Publication;
use App\Models\User;
use App\Models\Project;
use Livewire\WithFileUploads;

class PublicationsManager extends Component
{
    use WithFileUploads;
    protected $listeners = [
        'editPublication' => 'edit',
        'deletePublication' => 'confirmDelete',
    ];
    public $publications;
    public $authors;
    public $title, $abstract, $doi, $year, $pdf;
    public $selectedAuthors = [];
    public $selectedProject = null;
    public $projects = [];
    public $publicationId;
    public $isOpen = false;
    public $confirmingDelete = false;
    public $deleteId = null;
    public $search = '';

    public function render()
    {
        $this->publications = Publication::with('authors')
            ->where('title', 'like', '%' . $this->search . '%')
            ->latest()
            ->get();

        $this->authors = User::all();

        $this->projects = Project::whereNull('end_date')->orderBy('title')->get();

        return view('livewire.admin.publications-manager')->layout('layouts.app');
    }

    // ================= MODALE =================

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    public function openModal()
    {
        $this->resetFields();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetFields()
    {
        $this->title = '';
        $this->abstract = '';
        $this->year = '';
        $this->doi = '';
        $this->pdf = null;
        $this->selectedAuthors = [];
        $this->selectedProject = null;
        $this->publicationId = null;
    }

    // ================= CRUD =================

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'abstract' => 'nullable|string',
            'doi' => 'nullable|string',
            'year' => 'nullable|integer|digits:4|min:1900|max:' . date('Y'),
            'pdf' => 'nullable|file|mimes:pdf|max:2048',
            'selectedAuthors' => 'required|array|min:1',
            'selectedProject' => 'nullable|exists:projects,id',
        ]);

        if ($this->publicationId) {
        $existing = Publication::with('authors')->findOrFail($this->publicationId);

        if (!$existing->canBeEditedBy(auth()->user())) {
            abort(403, 'Non autorizzato');
        }
        }

        $hasTeacher = User::whereIn('id', $this->selectedAuthors)
            ->where('role', 'docente')
            ->exists();

        if (!$hasTeacher) {
            $this->addError(
                'selectedAuthors',
                'La pubblicazione deve avere almeno un docente tra gli autori.'
            );
            return;
        }

        if ($this->selectedProject) {
            $project = Project::find($this->selectedProject);

            if ($project && $project->end_date !== null) {

            $this->addError(
                'selectedProject',
                'È possibile associare una pubblicazione solo ad un progetto ancora in corso.'
            );

            return;
            }
        }

        $data = [
            'title' => $this->title,
            'abstract' => $this->abstract,
            'year' => $this->year,
            'doi' => $this->doi,
            'project_id' => $this->selectedProject,
        ];

        if ($this->pdf) {
            $data['pdf_path'] = $this->pdf->store('publications', 'public');
        }

        $publication = Publication::updateOrCreate(
            ['id' => $this->publicationId],
            $data
        );

        // 🔥 SINCRONIZZA AUTORI
        $publication->authors()->sync($this->selectedAuthors);

        session()->flash('success', $this->publicationId 
            ? 'Pubblicazione aggiornata con successo' 
            : 'Pubblicazione creata con successo'
        );

        $this->resetFields();
        $this->closeModal();
    }

    public function edit($id)
    {
        $pub = Publication::with('authors')->findOrFail($id);

        if (!$pub->canBeEditedBy(auth()->user())) {
            abort(403);
        }

        $this->publicationId = $id;
        $this->title = $pub->title;
        $this->abstract = $pub->abstract;
        $this->doi = $pub->doi;
        $this->year = $pub->year;
        $this->selectedAuthors = $pub->authors->pluck('id')->toArray();
        $this->selectedProject = $pub->project_id;

        $this->isOpen = true;
    }

    public function delete()
    {
        $pub = Publication::findOrFail($this->deleteId);
        
        if (!$pub->canBeEditedBy(auth()->user())) {
            abort(403);
        }

        $pub->delete();

        $this->confirmingDelete = false;
        $this->deleteId = null;

        session()->flash('success', 'Pubblicazione eliminata');
    }
}
