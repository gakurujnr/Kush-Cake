<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function Image()
    {
        return $this->hasOne(ProductImage::class);
    }

    public function Reviews()
    {
        return $this->hasMany(Review::class);
    }
}
