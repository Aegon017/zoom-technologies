<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Package;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class StudentStudyMaterail extends Component
{
    public $slug = '';

    public $courseName = '';

    public $studyMaterials = [];

    public function mount()
    {
        $subscription = Session::get('subscription');
        if ($subscription == 'paid') {
            $course = Course::where('slug', $this->slug)->with('studyMaterial')->first();
            $package = Package::where('slug', $this->slug)->first();
            if ($package) {
                $courses = Course::findMany($package->courses);
                $this->studyMaterials = $courses->flatMap(function ($course) {
                    return $course->studyMaterial->where('subscription', 'Paid');
                });
                $this->courseName = $package->name;
            } else {
                $this->studyMaterials = $course->studyMaterial->where('subscription', 'Paid');
                $this->courseName = $course->name;
            }
        } else {
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
    }

    public function render()
    {
        return view('livewire.student-study-materail');
    }
}
