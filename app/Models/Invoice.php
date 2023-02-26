<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'PO_NO',
        'In_No',
        'sup_name',
        'recipient',
        'price',
        'invoices_file'
    ];
}
