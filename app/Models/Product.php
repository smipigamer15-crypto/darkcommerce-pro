<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'sku', 'description', 'short_description',
        'price', 'discount_price', 'cost_price', 'stock',
        'low_stock_threshold', 'brand_id', 'is_active', 'is_featured',
        'is_digital', 'sales_count', 'views_count', 'rating', 'reviews_count',
        'weight', 'dimensions', 'specifications',
        'meta_title', 'meta_description', 'meta_keywords',
        'discount_start', 'discount_end',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'specifications' => 'array',
        'dimensions' => 'array',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getPrimaryImageAttribute()
    {
        return $this->images->first();
    }

    public function getFinalPriceAttribute(): float
    {
        if ($this->discount_price && $this->discount_price > 0) {
            return $this->discount_price;
        }
        return $this->price;
    }

    public function getDiscountPercentageAttribute(): ?int
    {
        if ($this->discount_price && $this->price > 0) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return null;
    }

    public function isDiscountActive(): bool
    {
        return $this->discount_price && $this->discount_price > 0;
    }



    public function isInStock(): bool
    {
        return $this->stock > 0;
    }
    
}