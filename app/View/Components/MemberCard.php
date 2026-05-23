<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class MemberCard extends Component
{
    
    public $name, $role, $field, $bio, $image;

    public function __construct($name, $role, $field, $bio, $image)
    {
        $this->name = $name;
        $this->role = $role;
        $this->field = $field;
        $this->bio = $bio;
        $this->image = $image;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.member-card');
    }
}
