<?php

namespace App\Listeners;

use App\Events\ContactDeleted;
use Illuminate\Support\Facades\Log;

class LogContactDeleted
{
    public function handle(ContactDeleted $event): void
    {
        Log::warning('Contact Deleted', [
            'user_id' => $event->contact->user_id,
            'name'    => $event->contact->name,
            'email'   => $event->contact->email,
            'time'    => now()->toDateTimeString(),
        ]);
    }
}