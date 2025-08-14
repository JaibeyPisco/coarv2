<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'places';
    
    protected $fillable = ['name', 'description'];
}
