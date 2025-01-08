<?php

namespace App\View\Components;

use App\Models\Course;
use App\Models\OtherStudyMaterial;
use App\Models\Package;
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
