<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $casts = [
        'name' => \App\Enums\Products\Size::class,
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
