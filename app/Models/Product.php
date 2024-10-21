<?php

namespace App\Models;

use App\Enums\Products\Gender;
use App\Services\Contract\FileStorageServiceContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'directory',
        'title',
        'description',
        'gender',
        'size',
        'SKU',
        'price',
        'new_price',
        'thumbnail',
    ];

    protected $hidden = [];

    protected $casts = [
        'gender' => Gender::class,
    ];

    public function quickOrder(): HasMany
    {
        return $this->hasMany(QuickOrder::class);
    }

//    public function variants()
//    {
//        return $this->hasMany(ProductVariant::class);
//    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function favoritedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorite_products', 'user_id', 'product_id');
    }

//    public function images(): MorphMany
//    {
//        return $this->morphMany(Image::class, 'imageable');
//    }
//
//    public function images(): HasMany
//    {
//        return $this->hasMany(Image::class);
//    }


    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('quantity', '>', 0);
    }

    //todo followers()

    public function thumbnailUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $key = "products.thumbnail.{$this->attributes['thumbnail']}";

                if (!Storage::has($this->attributes['thumbnail'])) {
                    return $this->attributes['thumbnail'];
                }

                if (!Cache::has($key)) {
                    $link = Storage::temporaryUrl($this->attributes['thumbnail'], now()->addMinutes(10));
                    Cache::put($key, $link, 570);
                }

                if (Storage::has($this->attributes['thumbnail'])) {
                    return Storage::temporaryUrl($this->attributes['thumbnail'], now()->addMinutes(10));
                }

                return Cache::get($key);
            }
        );
    }

    public function setThumbnailAttribute($image)
    {
        $fileStorage = app(FileStorageServiceContract::class);

        if (!empty($this->attributes['thumbnail'])) {
            $fileStorage->remove($this->attributes['thumbnail']);
        }

        $this->attributes['thumbnail'] = $fileStorage->upload(
            $image,
            $this->attributes['directory']
        );
    }

    public function finalPrice(): Attribute
    {
        return Attribute::make(
            get: fn() => round(($this->attributes['new_price'] && $this->attributes['new_price'] > 0
                ? $this->attributes['new_price']
                : $this->attributes['price']
            ), 2)
        );
    }

    public function discount(): Attribute
    {
        return Attribute::make(
            get: function () {
                $price = $this->attributes['price'];
                $newPrice = $this->attributes['new_price'];

                if (empty($newPrice) || $newPrice === 0 || $price == $newPrice) { //todo for hide negative discount set $price <= $newPrice
                    return null;
                } else {
                    return round(($price - $newPrice) / $price, 2) * 100;
                }
            }
        );
    }

    public function isExists(): Attribute
    {
        return Attribute::get(fn() => $this->attributes['quantity'] > 0);
    }
}
