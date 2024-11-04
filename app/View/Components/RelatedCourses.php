<?php

namespace App\View\Components;

use App\Models\Course;
use App\Models\Package;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RelatedCourses extends Component
{
    public $items;
    public function __construct()
    {
        $this->items = Course::all()->concat(Package::all());
    }

    public function render(): View|Closure|string
    {
        return view('components.related-courses');
    }
}
