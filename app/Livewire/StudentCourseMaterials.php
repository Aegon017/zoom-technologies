<?php

namespace App\Livewire;

use App\Models\OtherStudyMaterial;
use App\Models\StudyMaterial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class StudentCourseMaterials extends Component
{
    public $courses;

    public $packages;

    public $subscription = '';

    public $courseStudyMaterials;

    public $otherStudyMaterials;

    public function mount()
    {
        $user = Auth::user();
        if ($this->subscription == 'free') {
            $this->courseStudyMaterials = StudyMaterial::where('subscription', 'Free')->get();
            $this->otherStudyMaterials = OtherStudyMaterial::where('subscription', 'Free')->get();
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
        Session::put('subscription', $this->subscription);
    }

    public function render()
    {
        return view('livewire.student-course-materials');
    }
}
