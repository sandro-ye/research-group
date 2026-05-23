<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class PublicationCard extends Component
{
    public $title;
    public $abstract;
    public $authors;
    public $year;
    public $doi;

    public function __construct($title, $abstract, $authors, $year, $doi)
    {
        $this->title = $title;
        $this->abstract = $abstract;
        $this->authors = $authors;
        $this->year = $year;
        $this->doi = $doi;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.publication-card');
    }
}
