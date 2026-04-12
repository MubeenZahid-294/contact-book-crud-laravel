<?php

namespace App\Listeners;

use App\Events\ContactCreated;
use Illuminate\Support\Facades\Log;

class LogContactCreated
{
    public function handle(ContactCreated $event): void
    {
        Log::info('Contact Created', [
            'user_id' => $event->contact->user_id,
            'name'    => $event->contact->name,
            'email'   => $event->contact->email,
            'time'    => now()->toDateTimeString(),
        ]);
    }
}