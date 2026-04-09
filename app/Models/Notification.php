<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id', 'message', 'type', 'icon', 'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeOwned($query)
    {
        return $query->where('user_id', auth()->id());
    }
}