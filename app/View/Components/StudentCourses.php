<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StudentCourses extends Component
{
    public $items;

    public $otherStudyMaterials;

    public function __construct() {}

    public function render(): View|Closure|string
    {
        return view('components.student-courses');
    }
}
