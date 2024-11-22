<?php

namespace App\Providers;

use App\Events\MeetingCredentialsUpdatedEvent;
use App\Listeners\SendMeetingCredentialsUpdatedEmail;
use App\Models\Course;
use App\Observers\CourseObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Illuminate\Support\Facades\Route;

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
        );

        // Livewire::setScriptRoute(function ($handle) {
        //     return Route::get('/zoom-technologies/vendor/livewire/livewire/dist/livewire.js', $handle);
        // });

        // Livewire::setUpdateRoute(function ($handle) {
        //     return Route::post('/zoom-technologies/livewire/update', $handle);
        // });
    }
}
