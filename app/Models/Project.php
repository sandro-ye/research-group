<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'members',
        'body',
    ];

    public function members()
    {
        return $this->belongsToMany(User::class);
    }

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    public function isCompleted()
    {
        return !is_null($this->end_date);
    }

    // da modificare a seguito cambiamento relazione con Publication
    public function assignPublication($publicationId)
    {
        if (!$this->isCompleted()) {
            throw new \Exception('Non puoi associare una pubblicazione a un progetto in corso');
        }

        $this->publication_id = $publicationId;
        $this->save();
    }

    public function canBeEditedBy($user)
    {
        return $user && (
            $user->isAdmin() ||
            ($this->members->contains($user->id) && $user->isDocente())
        );
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
