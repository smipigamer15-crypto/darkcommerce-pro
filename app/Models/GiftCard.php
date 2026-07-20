<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    protected $fillable = [
        'code', 'amount', 'balance', 'from_name', 'to_name',
        'to_email', 'message', 'is_active', 'expires_at', 'used_at', 'used_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
        'amount' => 'decimal:2',
        'balance' => 'decimal:2',
    ];

    public function usedBy()
    {
        return $this->belongsTo(User::class, 'used_by');
    }

    public function isExpired(): bool
    {
        return $this->expires_at && now()->gt($this->expires_at);
    }

    public function hasBalance(): bool
    {
        return $this->balance > 0;
    }
}