<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class po_details extends Model
{
    use HasFactory;
    protected $table ="po_details";

    protected $fillable =[
        'PO_NO','date','pcs','teams_of_payment','delivery_date','attn','company_name','reason_to_buy','id',
    ];
}
