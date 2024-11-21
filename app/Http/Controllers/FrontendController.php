<?php

namespace App\Http\Controllers;

use App\Actions\CalculatePrice;
use App\Models\Brochure;
use App\Models\CorporateTraining;
use App\Models\Course;
use App\Models\FaqsSection;
use App\Models\FeatureCard;
use App\Models\FeatureSection;
use App\Models\FreeMaterialSection;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Order;
use App\Models\Package;
use App\Models\PageMetaDetails;
use App\Models\PageSchema;
use App\Models\PromoSection;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\TestimonialSection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function renderHome()
    {
        $pageSchema = PageSchema::where('page_name', 'Home')->first();
        $metaDetail = PageMetaDetails::where('page_name', 'Home')->first();
        $sliders = Slider::where('status', 1)->get();
        $promoSections = PromoSection::all();
        $featureSection = FeatureSection::find(1);
        $featureCards = FeatureCard::all();
        $freeMaterials = FreeMaterialSection::all();
        $testimonialSection = TestimonialSection::find(1);
        $testimonials = Testimonial::all();
        $clients = CorporateTraining::all();
        $faqs = FaqsSection::all();
        $brochures = Brochure::all();
        return view('pages.home', compact('metaDetail', 'pageSchema', 'sliders', 'promoSections', 'featureSection', 'featureCards', 'freeMaterials', 'testimonialSection', 'testimonials', 'clients', 'faqs', 'brochures'));
    }

    public function renderNewsList()
    {
        $news = News::all();
        $metaDetail = PageMetaDetails::where('page_name', 'News list')->first();
        $pageSchema = PageSchema::where('page_name', 'News list')->first();
        return view('pages.news-list', compact('news', 'metaDetail', 'pageSchema'));
    }

    public function renderNews($slug)
    {
        $metaDetail = News::where('slug', $slug)->first()->metaDetail;
        $pageSchema = PageSchema::where('page_name', $metaDetail->name)->first();
        return view('pages.news', compact('slug', 'metaDetail', 'pageSchema'));
    }

    public function renderCourseList()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Course list')->first();
        $pageSchema = PageSchema::where('page_name', 'Course list')->first();
        return view('pages.course-list', compact('metaDetail', 'pageSchema'));
    }

    public function renderContact()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Contact')->first();
        $pageSchema = PageSchema::where('page_name', 'Contact')->first();
        return view('pages.contact', compact('metaDetail', 'pageSchema'));
    }

    public function renderCourse($slug, CalculatePrice $calculatePrice)
    {
        $package = Package::where('slug', $slug)->first();
        $course = Course::where('slug', $slug)->first();
        $product = $course ?? $package;
        $prices = $calculatePrice->execute($product->actual_price, $product->sale_price);
        $packageCourses = optional($package)->courses ? Course::findMany($package->courses) : [];
        $pageSchema = PageSchema::where('page_name', $product->name)->first();
        return view('pages.course', compact('product', 'packageCourses', 'pageSchema', 'prices'));
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
        $pageSchema = PageSchema::where('page_name', 'Upcoming schedule')->first();
        return view('pages.upcoming-batches', compact('latestSchedules', 'metaDetail', 'latestPackageSchedules', 'pageSchema'));
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
        $pageSchema = PageSchema::where('page_name', $newsCategory->name)->first();
        return view('pages.news-list', compact('news', 'metaDetail', 'pageSchema'));
    }

    public function renderTestimonials()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Testimonials')->first();
        $pageSchema = PageSchema::where('page_name', 'Testimonials')->first();
        return view('pages.testimonials', compact('metaDetail', 'pageSchema'));
    }

    public function renderMemorableMoments()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Memorable moments')->first();
        $pageSchema = PageSchema::where('page_name', 'Memorable moments')->first();
        return view('pages.memorable-moments', compact('metaDetail', 'pageSchema'));
    }

    public function renderFranchisee()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Franchisee')->first();
        $pageSchema = PageSchema::where('page_name', 'Franchisee')->first();
        return view('pages.franchisee', compact('metaDetail', 'pageSchema'));
    }

    public function renderFreeEbooks()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Study material')->first();
        $materials = Course::with('studyMaterial')->get()->flatMap->studyMaterial;
        $pageSchema = PageSchema::where('page_name', 'Study material')->first();
        return view('pages.free-ebooks', compact('metaDetail', 'materials', 'pageSchema'));
    }
}
