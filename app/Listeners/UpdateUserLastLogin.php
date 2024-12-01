<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserLastLogin implements ShouldQueue
{
    // use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        try {
            $user = $event->user;

            // Update last login timestamp
            $user->updateLastLogin();

            // Optional: Log the login event
            Log::info("User logged in: {$user->email} at " . now());
        } catch (\Exception $e) {
            // Log any errors during the process
            Log::error("Error updating last login: " . $e->getMessage());
        }
    }
}