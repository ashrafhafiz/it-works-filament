<?php

namespace App\Providers;

use App\Models\Location;
use App\Observers\LocationObserver;
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
        // Location::observe(LocationObserver::class);
        // use instead: #[ObservedBy([LocationObserver::class])]
        // in the Location model.
    }
}
