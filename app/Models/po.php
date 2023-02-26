<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class po extends Model
{
    use HasFactory;
    protected $table ="po";

    protected $fillable =[
        'PO_NO','product','pcs','price_pcs','total_price'
    ];
    
}
