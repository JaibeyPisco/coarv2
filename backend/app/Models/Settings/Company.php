<?php

namespace App\Models\Settings;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //

    protected $table = 'empresa';
    
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
