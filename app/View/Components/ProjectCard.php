<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ProjectCard extends Component
{
    public $title;
    public $description;
    public $members;
    public function __construct($title, $description, $members = [])
    {
        $this->title = $title;
        $this->description = $description;
        $this->members = $members;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.project-card');
    }
}
