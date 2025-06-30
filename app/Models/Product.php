<?php

namespace App\Models;

use App\Models\offerPool;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'name',
        'category_id',
        'points_required',
        'description',
    ];

    public function offerPool()
    {
        return $this->hasOne(OfferPool::class, 'product_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
