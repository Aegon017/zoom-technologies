<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentStudyMaterail extends Component
{
    public $slug = '';
    public $courseName = '';
    public $studyMaterials = [];
    public function mount()
    {
        $user = Auth::user();
        $course = Course::where('slug', $this->slug)->with('studyMaterial')->first();
        $package = Package::where('slug', $this->slug)->first();
        if ($package) {
            $courses = Course::findMany($package->courses);
            $orderSuccess = $user->orders()
                ->where('package_id', $package->id)
                ->whereHas('payment', function ($query) {
                    $query->where('status', 'success');
                })
                ->first();
            if ($orderSuccess !== null) {
                $this->studyMaterials = $courses->flatMap(function ($course) {
                    return $course->studyMaterial;
                });
            } else {
                $this->studyMaterials = $courses->flatMap(function ($course) {
                    return $course->studyMaterial->where('subscription', 'Free');
                });
            }
            $this->courseName = $package->name;
        } else {
            $orderSuccess = $user->orders()
                ->where('course_id', $course->id)
                ->whereHas('payment', function ($query) {
                    $query->where('status', 'success');
                })
                ->first();
            if ($orderSuccess !== null) {
                $this->studyMaterials = $course->studyMaterial;
            } else {
                $this->studyMaterials = $course->studyMaterial->where('subscription', 'Free');
            }
            $this->courseName = $course->name;
        }
    }
    public function render()
    {
        return view('livewire.student-study-materail');
    }
}
