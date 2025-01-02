<?php

namespace App\View\Components;

use App\Models\Course;
use App\Models\Package;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StudentCourses extends Component
{
    public $courses;

    public $packages;

    public function __construct()
    {
        $this->courses = Course::all();
        $this->packages = Package::all();
    }

    public function render(): View|Closure|string
    {
        return view('components.student-courses');
    }
}
