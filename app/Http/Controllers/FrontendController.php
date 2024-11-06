<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Order;
use App\Models\Package;
use App\Models\PageMetaDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function renderHome()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Home')->first();
        return view('pages.home', compact('metaDetail'));
    }

    public function renderNewsList()
    {
        $news = News::all();
        $metaDetail = PageMetaDetails::where('page_name', 'News list')->first();
        return view('pages.news-list', compact('news', 'metaDetail'));
    }

    public function renderNews($slug)
    {
        $metaDetail = News::where('slug', $slug)->first()->metaDetail;
        return view('pages.news', compact('slug', 'metaDetail'));
    }

    public function renderCourseList()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Course list')->first();
        return view('pages.course-list', compact('metaDetail'));
    }

    public function renderContact()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Contact')->first();
        return view('pages.contact', compact('metaDetail'));
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
        $metaDetail = PageMetaDetails::where('page_name', 'Upcoming schedule')->first();
        $latestSchedules = Course::with('schedule')->get()->map(function ($course) {
            $latestSchedule = $course->schedule->firstWhere('start_date', '>=', Carbon::today());
            return ['item' => $course, 'latest_schedule' => $latestSchedule,];
        });
        
        $packages = Package::all();
        $latestPackageSchedules = collect($packages)->map(function ($package) {
            $packageSchedules = Course::findMany($package->courses);

            $latestSchedule = $packageSchedules->flatMap(function ($course) {
                return optional($course->schedule)->filter(function ($schedule) {
                    return $schedule->start_date >= Carbon::today();
                });
            })->sortByDesc('start_date')->first();

            return $latestSchedule ? [
                'package' => $package,
                'latest_schedule' => $latestSchedule,
            ] : null;
        })->filter()->values()->all();

        return view('pages.upcoming-batches', compact('latestSchedules', 'metaDetail', 'latestPackageSchedules'));
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
        $metaDetail = $newsCategory->metaDetail;
        return view('pages.news-list', compact('news', 'metaDetail'));
    }

    public function renderTestimonials()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Testimonials')->first();
        return view('pages.testimonials', compact('metaDetail'));
    }

    public function renderMemorableMoments()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Memorable moments')->first();
        return view('pages.memorable-moments', compact('metaDetail'));
    }

    public function renderFranchisee()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Franchisee')->first();
        return view('pages.franchisee', compact('metaDetail'));
    }
}
