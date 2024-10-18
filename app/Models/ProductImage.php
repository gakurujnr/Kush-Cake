<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;
    // Add the 'url' attribute to the appended properties
    protected $appends = ['url'];
    /*public function Product()
    {
        return $this->belongsTo(Product::class);
    }*/
     // Define the accessor for the full URL of the image
    public function getUrlAttribute()
    {
        // Assuming 'path' is the column storing the image path
       return Storage::url($this->image_url);
     }

}
