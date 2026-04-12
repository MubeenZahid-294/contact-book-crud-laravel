<?php

namespace App\Listeners;

use App\Events\ContactUpdated;
use Illuminate\Support\Facades\Log;

class LogContactUpdated
{
    public function handle(ContactUpdated $event): void
    {
        Log::info('Contact Updated', [
            'user_id' => $event->contact->user_id,
            'name'    => $event->contact->name,
            'email'   => $event->contact->email,
            'time'    => now()->toDateTimeString(),
        ]);
    }
}