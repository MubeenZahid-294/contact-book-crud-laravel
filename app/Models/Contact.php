<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'phone',
        'address', 'company', 'is_favorite', 'photo'
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOwned($query)
    {
        return $query->where('user_id', auth()->id());
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%")
              ->orWhere('phone', 'like', "%{$term}%")
              ->orWhere('company', 'like', "%{$term}%");
        });
    }
    public function tags()
{
    return $this->belongsToMany(Tag::class);
}
}
