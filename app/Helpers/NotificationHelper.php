<?php

namespace App\Helpers;

use App\Models\Notification;

class NotificationHelper
{
    public static function create(string $message, string $type = 'success', string $icon = 'contact'): void
    {
        if (auth()->check()) {
            Notification::create([
                'user_id' => auth()->id(),
                'message' => $message,
                'type'    => $type,
                'icon'    => $icon,
            ]);
        }
    }
}