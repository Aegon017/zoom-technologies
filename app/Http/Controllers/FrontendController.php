<?php

namespace App\Http\Controllers;

use App\Actions\CalculatePrice;
use App\Models\AboutUsSection;
use App\Models\Address;
use App\Models\BankTransfer;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Brochure;
use App\Models\CorporateTraining;
use App\Models\Course;
use App\Models\FaqsSection;
use App\Models\FeatureCard;
use App\Models\FeatureSection;
use App\Models\FooterOffice;
use App\Models\Franchisee;
use App\Models\FreeMaterialSection;
use App\Models\MemorableMoments;
use App\Models\Order;
use App\Models\OtherStudyMaterial;
use App\Models\Package;
use App\Models\PageMetaDetails;
use App\Models\PageSchema;
use App\Models\PromoSection;
use App\Models\QRCode;
use App\Models\Schedule;
use App\Models\Slider;
use App\Models\StudyMaterialPage;
use App\Models\TermsAndCondition;
use App\Models\Testimonial;
use App\Models\TestimonialSection;
use App\Models\Thankyou;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
    public function renderHome()
    {
        $pageSchema = PageSchema::where('page_name', 'Home')->first();
        $metaDetail = PageMetaDetails::where('page_name', 'Home')->first();
        $sliders = Slider::where('status', 1)->get();
        $promoSections = PromoSection::all();
        $featureSection = FeatureSection::first();
        $featureCards = FeatureCard::all();
        $freeMaterials = FreeMaterialSection::all();
        $testimonialSection = TestimonialSection::first();
        $testimonials = Testimonial::take(4)->get();
        $clients = CorporateTraining::all();
        $faqs = FaqsSection::all();
        $brochures = Brochure::all();
        $aboutUsSection = AboutUsSection::first();

        return view('pages.home', compact('metaDetail', 'pageSchema', 'sliders', 'promoSections', 'featureSection', 'featureCards', 'freeMaterials', 'testimonialSection', 'testimonials', 'clients', 'faqs', 'brochures', 'aboutUsSection'));
    }

    public function renderBlogList()
    {
        $news = Blog::all();
        $metaDetail = PageMetaDetails::where('page_name', 'News list')->first();
        $pageSchema = PageSchema::where('page_name', 'News list')->first();

        return view('pages.news-list', compact('news', 'metaDetail', 'pageSchema'));
    }

    public function renderBlog($slug)
    {
        $metaDetail = Blog::where('slug', $slug)->first()->metaDetail;
        $pageSchema = PageSchema::where('page_name', $metaDetail?->name)->first();

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
        $packageCourses = optional($package)->courses ? Course::findMany($package->courses) : [$course];
        $pageSchema = PageSchema::where('page_name', $product->name)->first();
        $metaDetail = $product->metaDetail;
        $terms = TermsAndCondition::first();

        return view('pages.course', compact('product', 'packageCourses', 'pageSchema', 'prices', 'metaDetail', 'terms'));
    }

    public function renderUpcomingBatches()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Upcoming schedule')->first();
        $latestSchedules = Course::with(['schedule' => function ($query) {
            $query->where('start_date', '>', today())
                ->orderBy('start_date', 'asc')
                ->limit(1);
        }])
            ->whereHas('schedule', function ($query) {
                $query->where('status', true)->where('start_date', '>', today());
            })
            ->get()
            ->map(function ($course) {
                $latestSchedule = $course->schedule->first();
                $timings = collect();

                if ($latestSchedule) {
                    $formattedDate = Carbon::parse($latestSchedule->start_date)->format('Y-m-d');
                    $timings = $course->schedule()->where('start_date', $formattedDate)->orderBy('time', 'asc')->get();
                }

                return [
                    'item' => $course,
                    'latest_schedule' => $latestSchedule,
                    'timings' => $timings,
                ];
            });
        $latestPackageSchedules = Package::all()->map(function ($package) {
            $courseIds = $package->courses; // Assuming courses is an array of course IDs

            $latestSchedule = Schedule::whereIn('course_id', $courseIds)
                ->where('start_date', '>', today())
                ->orderBy('start_date', 'asc')
                ->first();

            $timings = collect();

            if ($latestSchedule) {
                $formattedDate = Carbon::parse($latestSchedule->start_date)->format('Y-m-d');
                // Get timings for the latest schedule
                $timings = Schedule::where('course_id', $latestSchedule->course_id)
                    ->whereDate('start_date', $formattedDate)
                    ->orderBy('time', 'asc')
                    ->get();
            }

            return $latestSchedule ? [
                'item' => $package,
                'latest_schedule' => $latestSchedule,
                'timings' => $timings,
            ] : null;
        })
            ->filter()
            ->values();
        $upcomingSchedules = ($latestSchedules->concat($latestPackageSchedules))->sortBy('item.position');
        $pageSchema = PageSchema::where('page_name', 'Upcoming schedule')->first();

        return view('pages.upcoming-batches', compact('upcomingSchedules', 'metaDetail', 'pageSchema'));
    }

    public function render_account()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();

        return view('dashboard', compact('orders'));
    }

    public function order_details($id)
    {
        $order = Order::find($id);

        return view('components.order-details', compact('order'));
    }

    public function renderBlogCategory($category)
    {
        $newsCategory = BlogCategory::where('name', $category)->first();
        $news = $newsCategory->blog ?? collect();
        $metaDetail = $newsCategory->metaDetail;
        $pageSchema = PageSchema::where('page_name', $newsCategory->name)->first();

        return view('pages.news-list', compact('news', 'metaDetail', 'pageSchema'));
    }

    public function renderTestimonials()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Testimonials')->first();
        $pageSchema = PageSchema::where('page_name', 'Testimonials')->first();
        $testimonials = Testimonial::all();

        return view('pages.testimonials', compact('metaDetail', 'pageSchema', 'testimonials'));
    }

    public function renderMemorableMoments()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Memorable moments')->first();
        $pageSchema = PageSchema::where('page_name', 'Memorable moments')->first();
        $moments = MemorableMoments::all();

        return view('pages.memorable-moments', compact('metaDetail', 'pageSchema', 'moments'));
    }

    public function renderFranchisee()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Franchisee')->first();
        $pageSchema = PageSchema::where('page_name', 'Franchisee')->first();
        $pageContent = Franchisee::first()?->page_content;

        return view('pages.franchisee', compact('metaDetail', 'pageSchema', 'pageContent'));
    }

    public function renderFreeEbooks()
    {
        $metaDetail = PageMetaDetails::where('page_name', 'Study material')->first();
        $materials = Course::with('studyMaterial')->get()->flatMap->studyMaterial->where('subscription', 'Direct Access')->concat(OtherStudyMaterial::where('subscription', 'Direct Access')->get());
        $pageSchema = PageSchema::where('page_name', 'Study material')->first();
        $pageContent = StudyMaterialPage::first()?->page_content;

        return view('pages.free-ebooks', compact('metaDetail', 'materials', 'pageSchema', 'pageContent'));
    }

    public function renderMyCourse($slug)
    {
        return view('pages.my-course', compact('slug'));
    }

    public function renderCourses()
    {
        return view('pages.user-study-materail');
    }

    public function checkout(Request $request)
    {
        $scheduleIDs = array_values(array_filter($request->all(), fn($key) => str_starts_with($key, 'course_schedule'), ARRAY_FILTER_USE_KEY));
        Session::put('scheduleIDs', $scheduleIDs);
        $thankyou = Thankyou::first();
        $bankTransferDetails = BankTransfer::first();
        $qrCode = QRCode::first();

        return view('livewire.checkout', compact('request', 'thankyou', 'bankTransferDetails', 'qrCode'));
    }

    public function renderStudentStudyMaterials()
    {
        return view('pages.student-study-materials');
    }

    public function renderStudentStudyMaterialsType($subscription)
    {
        return view('pages.user-study-materail', compact('subscription'));
    }

    public function renderOnlineClasses()
    {
        $user = Auth::user();
        $successfulOrders = $user->orders()
            ->whereHas('payment', fn($query) => $query->where('status', 'success'))
            ->with(['schedule', 'payment' => fn($query) => $query->where('status', 'success')])
            ->get();

        return view('pages.online-classes', compact('successfulOrders'));
    }

    public function renderCertificates()
    {
        $metaDetail = null;
        $pageSchema = null;
        $certificates = Auth::user()->orders()
            ->whereHas('payment', function ($query) {
                $query->where('status', 'success');
            })
            ->whereHas('schedule', function ($query) {
                $query->where('certificate_status', true);
            })
            ->with('schedule')
            ->get();
        $companyAddress = FooterOffice::where('name', 'Registered Office')->first();
        return view('pages.certificates', compact('metaDetail', 'pageSchema', 'certificates', 'companyAddress'));
    }

    public function downloadCertificate() {}
}
