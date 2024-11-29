<?php

namespace App\View\Components;

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
                $course_name = $order->course_name;
                $course_slug = Str::slug($order->course_name);
                $courses[$course_name] ??= [
                    'courseName' => $course_name,
                    'courseSlug' => $course_slug,
                ];
            }
        }
        $this->courses = $courses ?? [];
    }

    public function render(): View|Closure|string
    {
        return view('components.student-courses');
    }
}
