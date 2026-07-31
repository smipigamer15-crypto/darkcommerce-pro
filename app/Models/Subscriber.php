<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'is_active',
        'subscribed_at',
        'unsubscribed_at',
        'unsubscribe_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    protected static function booted()
    {
    static::creating(function ($subscriber) {
        $recentFromIp = static::where('created_at', '>=', now()->subHour())->count();
        if ($recentFromIp >= 3) {
            throw new \Exception('Too many subscription attempts. Try again later.');
        }
    });
    }
}