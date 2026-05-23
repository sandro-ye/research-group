<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Announcement;

class AnnouncementsManager extends Component
{
    public $announcementId;
    public $title;
    public $content;
    public $is_active = true;

    public $search = '';
    public $isOpen = false;
    public $confirmingDelete = false;
    public $deleteId = null;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'is_active' => 'boolean',
    ];

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    public function getAnnouncementsProperty()
    {
        return Announcement::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);

        $this->announcementId = $announcement->id;
        $this->title = $announcement->title;
        $this->content = $announcement->content;
        $this->is_active = $announcement->is_active;

        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate();

        Announcement::updateOrCreate(
            ['id' => $this->announcementId],
            [
                'title' => $this->title,
                'content' => $this->content,
                'is_active' => $this->is_active,
            ]
        );

        $this->closeModal();
    }

    public function delete($id)
    {
        Announcement::findOrFail($id)->delete();
        $this->confirmingDelete = false;
        $this->deleteId = null;

        session()->flash('success', 'Avviso eliminato');
    }

    public function toggleActive($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->is_active = !$announcement->is_active;
        $announcement->save();

        session()->flash('success', 'Stato dell\'avviso aggiornato');
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->isOpen = false;
    }

    private function resetForm()
    {
        $this->announcementId = null;
        $this->title = '';
        $this->content = '';
        $this->is_active = true;
    }
    public function render()
    {
        return view('livewire.admin.announcements-manager')->layout('layouts.app');
    }
}
