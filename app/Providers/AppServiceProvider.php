<?php

namespace App\Providers;

use App\Events\ManualOrderCreatedEvent;
use App\Events\MeetingCredentialsUpdatedEvent;
use App\Listeners\CreateOrderSendMail;
use App\Listeners\SendMeetingCredentialsUpdatedEmail;
use App\Mail\EmailVerified;
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
            CreateOrderSendMail::class
        );
        Event::listen(Verified::class, function ($event) {
            $user = $event->user;
            Mail::to($user->email)->send(new EmailVerified($user));
        });

        // Livewire::setScriptRoute(function ($handle) {
        //     return Route::get('/zoom-technologies/vendor/livewire/livewire/dist/livewire.js', $handle);
        // });

        // Livewire::setUpdateRoute(function ($handle) {
        //     return Route::post('/zoom-technologies/livewire/update', $handle);
        // });
    }
}
