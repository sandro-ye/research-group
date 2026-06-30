<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;

class MembersManager extends Component
{
    use WithFileUploads;

    public $members;
    public $search = '';

    public $name, $email, $role, $bio, $academic_role, $password;
    public $photo;
    public $memberId;

    public $isOpen = false;
    public $confirmingDelete = false;
    public $deleteId = null;

    protected $messages = [
        'email.required' => 'L\'indirizzo email è obbligatorio.',
        'email.email' => 'Inserisci un indirizzo email valido.',
        'email.unique' => 'Questa email è già registrata.',
    ];

    public function render()
    {
        $this->members = User::orderBy('name')
            ->where('name', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.admin.members-manager')->layout('layouts.app');
    }

    // ================= MODALE =================

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
        $this->name = '';
        $this->email = '';
        $this->role = '';
        $this->bio = '';
        $this->academic_role = '';
        $this->password = '';
        $this->photo = null;
        $this->memberId = null;
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    // ================= CRUD =================

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email:rfc,filter|unique:users,email,' . $this->memberId,
            'password' => $this->memberId ? 'nullable|min:6' : 'required|min:6',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'bio' => $this->bio,
            'academic_role' => $this->academic_role,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->photo) {
            $path = $this->photo->store('profile-photos', 'public');
            $data['profile_photo_path'] = $path;
        }

        User::updateOrCreate(
            ['id' => $this->memberId],
            $data
        );

        session()->flash('success', 'Membro salvato con successo');

        $this->resetFields();
        $this->closeModal();
    }

    public function edit($id)
    {
        $member = User::findOrFail($id);

        $this->memberId = $id;
        $this->name = $member->name;
        $this->email = $member->email;
        $this->role = $member->role;
        $this->bio = $member->bio;
        $this->academic_role = $member->academic_role;

        $this->isOpen = true;
    }

    public function delete()
    {
        if ($this->deleteId == auth()->id()) {
            session()->flash('error', 'Non puoi eliminare te stesso');
            return;
        }

        User::find($this->deleteId)?->delete();

        $this->confirmingDelete = false;
        $this->deleteId = null;

        session()->flash('success', 'Membro eliminato');
    }
}
