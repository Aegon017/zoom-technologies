<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PaymentController;
use App\Livewire\NewsCard;
use App\Livewire\NewsCategory;
use Filament\Actions\Exports\Http\Controllers\DownloadExport;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'renderHome'])->name('render.home');
Route::prefix('/news')->group(function () {
    Route::get('/', [FrontendController::class, 'renderNewsList'])->name('render.news.list');
    Route::get('/{slug}', [FrontendController::class, 'renderNews'])->name('render.news');
    Route::get('/category/{category}', [FrontendController::class, 'renderNewsCategory'])->name('news.category');
});
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
    'verified',
])->group(function () {
    Route::get('/my-account', [FrontendController::class, 'render_account'])->name('dashboard');
    Route::get('/order-details/{id}', [FrontendController::class, 'order_details'])->name('order-details');
    Route::get('/my-account', [FrontendController::class, 'render_account'])->name('dashboard');
    Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
    Route::post('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::post('/payment/failure', [PaymentController::class, 'paymentFailure'])->name('payment.failure');
});

Route::get('/storage-link', function () {
    $target = storage_path('app/public');
    $link = $_SERVER['DOCUMENT_ROOT'] . '/zoom-technologies/public/storage';
    symlink($target, $link);
});

Route::get('/zoom-technologies/filament/exports/{export}/download', DownloadExport::class)
    ->name('filament.exports.download')
    ->middleware(['web', 'auth']);