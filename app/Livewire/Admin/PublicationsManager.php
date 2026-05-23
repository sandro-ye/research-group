<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Publication;
use App\Models\User;
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
    public $title, $abstract, $doi, $pdf;
    public $selectedAuthors = [];
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
        $this->doi = '';
        $this->pdf = null;
        $this->selectedAuthors = [];
        $this->publicationId = null;
    }

    // ================= CRUD =================

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'abstract' => 'nullable|string',
            'doi' => 'nullable|string',
            'pdf' => 'nullable|file|mimes:pdf|max:2048',
            'selectedAuthors' => 'required|array|min:1',
        ]);

        if ($this->publicationId) {
        $existing = Publication::with('authors')->findOrFail($this->publicationId);

        if (!$existing->canBeEditedBy(auth()->user())) {
            abort(403, 'Non autorizzato');
        }
    }

        $data = [
            'title' => $this->title,
            'abstract' => $this->abstract,
            'doi' => $this->doi,
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

        $this->selectedAuthors = $pub->authors->pluck('id')->toArray();

        $this->isOpen = true;
    }

    public function delete($id)
    {
        $pub = Publication::findOrFail($id);
        
        if (!$pub->canBeEditedBy(auth()->user())) {
            abort(403);
        }

        $pub->delete();

        $this->confirmingDelete = false;
        $this->deleteId = null;

        session()->flash('success', 'Pubblicazione eliminata');
    }
}
