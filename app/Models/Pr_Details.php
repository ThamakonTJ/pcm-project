<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pr_Details extends Model
{
    use HasFactory;
    protected $table ="prmultis";
    protected $fillable =[
        'Doc_NO ','id ','product','pcs','price_pcs','total_price','note',
    ];
}
