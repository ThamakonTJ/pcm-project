<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_image',
        'type_id',
        'brand_id',
        'model_id',
        'bom_id',
        'quantity'
    ];
}
