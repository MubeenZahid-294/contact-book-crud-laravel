<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\ContactCreated;
use App\Events\ContactUpdated;
use App\Events\ContactDeleted;
use App\Listeners\LogContactCreated;
use App\Listeners\LogContactUpdated;
use App\Listeners\LogContactDeleted;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(ContactCreated::class, LogContactCreated::class);
        Event::listen(ContactUpdated::class, LogContactUpdated::class);
        Event::listen(ContactDeleted::class, LogContactDeleted::class);
    }
}