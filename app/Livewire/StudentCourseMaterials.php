<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\OtherStudyMaterial;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
                if ($order->payment->status === 'success') {
                    return collect([$order->course]);
                }
                return collect([]);
            });
            $this->packages = $user->orders->flatMap(function ($order) {
                if ($order->payment->status === 'success') {
                    return collect([$order->package]);
                }
                return collect([]);
            });
        }
        $this->otherStudyMaterials = OtherStudyMaterial::where('subscription', 'Free')->get();
        Session::put('subscription', $this->subscription);
    }
    public function render()
    {
        return view('livewire.student-course-materials');
    }
}
