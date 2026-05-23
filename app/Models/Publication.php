<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = [
        'title',
        'description',
        'abstract',
        'authors',
        'body',
        'year',
        'doi',
    ];

    public function authors()
    {
        return $this->belongsToMany(User::class);
    }

    public function canBeEditedBy($user)
    {
        return $user && (
            $user->isAdmin() ||
            $this->authors->contains($user->id)
        );
    }

    public function project()
    {
        return $this->hasOne(Project::class);
    }
}
