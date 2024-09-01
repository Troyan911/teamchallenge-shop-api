<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuickOrder extends Model
{
    use HasFactory;
    protected $fillable=['customer_name'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
