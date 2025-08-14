<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class IncidenceTypes extends Model
{
    protected $table = 'incidence_types';
    
    protected $fillable = [    
        'name', 
        'level',
        'status'
    ];
}
