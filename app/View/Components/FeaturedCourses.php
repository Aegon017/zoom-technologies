<?php

namespace App\View\Components;

use App\Models\Course;
use App\Models\Package;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FeaturedCourses extends Component
{
    public $items;

    public function __construct()
    {
        $courses = Course::orderBy('position', 'asc')->get();
        $packages = Package::orderBy('position', 'asc')->get();
        $PakcageCourses = $courses->concat($packages);
        $this->items = $PakcageCourses->sortBy('position');
    }

    public function render(): View|Closure|string
    {
        return view('components.featured-courses');
    }
}
