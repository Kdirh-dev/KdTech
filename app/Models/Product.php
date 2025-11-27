<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'compare_price',
        'stock',
        'sku',
        'brand',
        'features',
        'images',
        'is_featured',
        'is_active',
        'category_id'
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Route model binding uses 'id' by default (standard behavior)
    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    public function getHasDiscountAttribute()
    {
        return $this->compare_price && $this->compare_price > $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->has_discount) return 0;
        return round(($this->compare_price - $this->price) / $this->compare_price * 100);
    }

    public function getMainImageAttribute()
    {
        $images = $this->images ?? [];
        if (!empty($images) && is_array($images)) {
            return $images[0];
        }
        return asset('images/placeholder-product.jpg');
    }

    // Nouvelle méthode pour obtenir toutes les URLs d'images
    public function getImageUrlsAttribute()
    {
        $images = $this->images ?? [];
        if (empty($images) || !is_array($images)) {
            return [asset('images/placeholder-product.jpg')];
        }
        return $images;
    }
}
