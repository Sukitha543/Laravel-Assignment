<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    //Product Model
    
    use HasFactory;
  
    protected $fillable = [
        'brand',
        'model',
        'product_code',
        'diameter',
        'type',
        'material',
        'strap',
        'water_resistance',
        'caliber',
        'price',
        'quantity',
        'image',
    ];

    public function getImageUrlAttribute()
    {
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        return asset('storage/' . $this->image);
    }

}
