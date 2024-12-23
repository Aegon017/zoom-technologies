<?php

namespace App\View\Components;

use App\Models\Course;
use App\Models\Order;
use App\Models\Package;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class StudentCourses extends Component
{
    public $courses;

    public $packages;

    public function __construct()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->get();
        foreach ($orders as $order) {
            if ($order->payment->status == 'success') {
                $course_id = $order->course_id;
                $package_id = $order->package_id;
                $courses[$course_id] ??= [
                    'course_id' => $course_id,
                ];
                $packages[$package_id] ??= [
                    'package_id' => $package_id,
                ];
            }
        }
        $this->packages = Package::findMany($packages ?? []);
        $this->courses = Course::findMany($courses ?? []);
    }

    public function render(): View|Closure|string
    {
        return view('components.student-courses');
    }
}
