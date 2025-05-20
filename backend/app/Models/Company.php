<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //

    protected $table = 'company';
    protected $fillable = [
        'id',
        'business_name',
        'trade_name',
        'document_number',
        'address',
        'phone',
        'email',
        'id_ubigeo',
    ];

}
