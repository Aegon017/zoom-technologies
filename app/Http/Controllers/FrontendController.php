<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Order;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function renderHome()
    {
        return view('pages.home');
    }

    public function renderNewsList()
    {
        $news = News::all();
        return view('pages.news-list', compact('news'));
    }

    public function renderNews($slug)
    {
        return view('pages.news', compact('slug'));
    }

    public function renderCourseList()
    {
        return view('pages.course-list');
    }

    public function renderContact()
    {
        return view('pages.contact');
    }

    public function renderCourse($slug)
    {
        $package = Package::where('slug', $slug)->first();
        $course = Course::where('slug', $slug)->first();
        $packageCourses = optional($package)->courses ? Course::findMany($package->courses) : [];
        return view('pages.course', compact('course', 'package', 'packageCourses'));
    }

    public function renderUpcomingBatches()
    {
        $latestSchedules = Course::with('schedule')->get()->map(function ($course) {
            $latestSchedule = $course->schedule->firstWhere('start_date', '>=', Carbon::today());
            return ['item' => $course, 'latest_schedule' => $latestSchedule,];
        });
        return view('pages.upcoming-batches', compact('latestSchedules'));
    }

    public function render_account()
    {
        $orders = Order::with('course')->where('user_id', Auth::id())->latest()->get();
        return view('dashboard', compact('orders'));
    }

    public function order_details($id)
    {
        $order = Order::find($id);
        return view('components.order-details', compact('order'));
    }

    public function renderNewsCategory($category)
    {
        $newsCategory = NewsCategory::where('name', $category)->first();
        $news = $newsCategory->news ?? collect();
        return view('pages.news-list', compact('news'));
    }
}
