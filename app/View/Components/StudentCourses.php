<?php

namespace App\View\Components;

use App\Models\Course;
use App\Models\Order;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class StudentCourses extends Component
{
    public $courses;

    public function __construct()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->get();
        foreach ($orders as $order) {
            if ($order->payment->status == 'success') {
                $course_id = $order->course_id;
                $courses[$course_id] ??= [
                    'course_id' => $course_id,
                ];
            }
        }
        $this->courses = Course::findMany($courses ?? []);
    }

    public function render(): View|Closure|string
    {
        return view('components.student-courses');
    }
}
