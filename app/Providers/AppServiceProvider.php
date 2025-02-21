<?php

namespace App\Providers;

use App\Events\ManualOrderCreatedEvent;
use App\Events\MeetingCredentialsUpdatedEvent;
use App\Events\ScheduleDeleted;
use App\Listeners\CreateOrderSendMail;
use App\Listeners\SendChooseScheduleNotification;
use App\Listeners\SendMeetingCredentialsUpdatedEmail;
use App\Mail\EmailVerified;
use App\Models\StickyContact;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            MeetingCredentialsUpdatedEvent::class,
            SendMeetingCredentialsUpdatedEmail::class,
            ManualOrderCreatedEvent::class,
            CreateOrderSendMail::class,
            ScheduleDeleted::class,
            SendChooseScheduleNotification::class
        );
        Event::listen(Verified::class, function ($event) {
            $user = $event->user;
            $stickyContact = StickyContact::with(['mobileNumber', 'email'])->first();
            Mail::to($user->email)->send(new EmailVerified($user, $stickyContact));
        });

        // Livewire::setScriptRoute(function ($handle) {
        //     return Route::get('/zoom-technologies/vendor/livewire/livewire/dist/livewire.js', $handle);
        // });

        // Livewire::setUpdateRoute(function ($handle) {
        //     return Route::post('/zoom-technologies/livewire/update', $handle);
        // });
    }
}
