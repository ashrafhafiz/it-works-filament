<?php

namespace App\Providers;

use App\Models\Location;
use App\Observers\LocationObserver;
use App\Listeners\UpdateUserLastLogin;
use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Support\Facades\Event::listen(
            \Illuminate\Auth\Events\Login::class,
            [UpdateUserLastLogin::class, 'handle']
        );
        // Location::observe(LocationObserver::class);
        // use instead: #[ObservedBy([LocationObserver::class])]
        // in the Location model.
    }
}