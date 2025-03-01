<?php

use App\Actions\Payment\GenerateInvoice;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PaymentController;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Exports\Http\Controllers\DownloadExport;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'renderHome'])->name('render.home');
Route::prefix('/blog')->group(function () {
    Route::get('/', [FrontendController::class, 'renderBlogList'])->name('render.news.list');
    Route::get('/{slug}', [FrontendController::class, 'renderBlog'])->name('render.news');
    Route::get('/category/{category}', [FrontendController::class, 'renderBlogCategory'])->name('news.category');
});

Route::get('/email-verified', [FrontendController::class, 'emailVerified'])->name('email.verified');
Route::get('/checkout', [FrontendController::class, 'checkout'])->name('checkout');
Route::post('/address/store', [FrontendController::class, 'addressStore'])->name('address.store');

Route::prefix('/training/india')->group(function () {
    Route::get('/courses', [FrontendController::class, 'renderCourseList'])->name('render.course.list');
    Route::get('/{slug}', [FrontendController::class, 'renderCourse'])->name('render.course');
    Route::get('/free/ebooks', [FrontendController::class, 'renderFreeEbooks'])->name('render.free.ebooks');
});
Route::get('/contact', [FrontendController::class, 'renderContact'])->name('render.contact');
Route::get('/upcoming-batches', [FrontendController::class, 'renderUpcomingBatches'])->name('render.upcoming.batches');
Route::get('/testimonials', [FrontendController::class, 'renderTestimonials'])->name('render.testimonials');
Route::get('/memorable-moments', [FrontendController::class, 'renderMemorableMoments'])->name('render.memorable-moments');
Route::get('/franchisee', [FrontendController::class, 'renderFranchisee'])->name('render.franchisee');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {
    Route::get('/my-orders', [FrontendController::class, 'render_account'])->name('render.myOrders');
    Route::get('/my-courses', [FrontendController::class, 'renderCourses'])->name('render.userCourses');
    Route::get('/my-courses/{slug}', [FrontendController::class, 'renderMyCourse'])->name('render.myCourse');
    Route::get('/order-details/{id}', [FrontendController::class, 'order_details'])->name('order-details');
    Route::get('/checkout/course', [FrontendController::class, 'checkout'])->name('checkout.course');
    Route::get('/student/study-materials', [FrontendController::class, 'renderStudentStudyMaterials'])->name('render.student.studyMaterials');
    Route::get('/student/study-materials/{subscription}', [FrontendController::class, 'renderStudentStudyMaterialsType'])->name('render.student.studyMaterials.type');
    Route::get('/student/online-classes', [FrontendController::class, 'renderOnlineClasses'])->name('render.online-classes');
    Route::get('/student/certificates', [FrontendController::class, 'renderCertificates'])->name('render.certificates');
});

Route::post('/payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');

Route::any('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::any('/payment/failure', [PaymentController::class, 'failure'])->name('payment.failure');

Route::get('/storage-link', function () {
    $target = storage_path('app/public');
    $link = $_SERVER['DOCUMENT_ROOT'] . '/zoom-technologies/public/storage';
    symlink($target, $link);
});

Route::get('/zoom-technologies/filament/exports/{export}/download', DownloadExport::class)
    ->name('filament.exports.download')
    ->middleware(['web', 'auth']);

Route::any('/phonepe/callback', [PaymentController::class, 'phonepeCallback'])->name('phonepe.callback');
