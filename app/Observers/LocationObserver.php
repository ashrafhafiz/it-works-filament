<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Location;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class LocationObserver
{
    /**
     * Handle the Location "created" event.
     */
    public function created(Location $location): void
    {
        $recipients = User::where('role', 'admin')->get();

        Notification::make()
            ->title('A new location has been created successfully')
            ->sendToDatabase($recipients);
    }

    /**
     * Handle the Location "updated" event.
     */
    public function updated(Location $location): void
    {
        $recipients = User::where('role', 'admin')->get();
        // dd($recipients);
        Notification::make()
            ->title('A new location has been updated successfully')
            ->sendToDatabase($recipients);
    }

    /**
     * Handle the Location "deleted" event.
     */
    public function deleted(Location $location): void
    {
        //
    }

    /**
     * Handle the Location "restored" event.
     */
    public function restored(Location $location): void
    {
        //
    }

    /**
     * Handle the Location "force deleted" event.
     */
    public function forceDeleted(Location $location): void
    {
        //
    }
}
