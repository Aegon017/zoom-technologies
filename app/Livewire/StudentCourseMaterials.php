<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\OtherStudyMaterial;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentCourseMaterials extends Component
{
    public $courses;
    public $packages;
    public $otherStudyMaterials;
    public $subscription = '';
    public function mount()
    {
        $user = Auth::user();
        if ($this->subscription == 'free') {
            $this->courses = Course::all();
            $this->packages = Package::all();
        } else {
            $this->courses = $user->orders->flatMap(function ($order) {
                return collect([$order->course]);
            });
            $this->packages = $user->orders->flatMap(function ($order) {
                return collect([$order->package]);
            });
        }
        $this->otherStudyMaterials = OtherStudyMaterial::where('subscription', 'Free')->get();
    }
    public function render()
    {
        return view('livewire.student-course-materials');
    }
}
