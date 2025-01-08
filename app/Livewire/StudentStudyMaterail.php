<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Package;
use Livewire\Component;

class StudentStudyMaterail extends Component
{
    public $slug = '';

    public $courseName = '';

    public $studyMaterials = [];

    public function mount()
    {
        $course = Course::where('slug', $this->slug)->with('studyMaterial')->first();
        $package = Package::where('slug', $this->slug)->first();
        if ($package) {
            $courses = Course::findMany($package->courses);
            $this->studyMaterials = $courses->flatMap(function ($course) {
                return $course->studyMaterial->where('subscription', 'Free');
            });
            $this->courseName = $package->name;
        } else {
            $this->studyMaterials = $course->studyMaterial->where('subscription', 'Free');
            $this->courseName = $course->name;
        }
    }

    public function render()
    {
        return view('livewire.student-study-materail');
    }
}
