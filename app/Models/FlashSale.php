<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    protected $fillable = ['title', 'description', 'starts_at', 'ends_at', 'discount_percentage', 'is_active'];
    protected $casts = ['starts_at' => 'datetime', 'ends_at' => 'datetime', 'is_active' => 'boolean'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'flash_sale_products')
            ->withPivot('sale_price', 'max_quantity', 'sold_count')
            ->withTimestamps();
    }

    public function isActive(): bool
    {
        return $this->is_active && now()->between($this->starts_at, $this->ends_at);
    }

    public function timeLeft(): array
    {
        $diff = now()->diff($this->ends_at);
        return ['hours' => $diff->h, 'minutes' => $diff->i, 'seconds' => $diff->s];
    }
}