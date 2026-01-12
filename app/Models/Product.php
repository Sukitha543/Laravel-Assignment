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

}
