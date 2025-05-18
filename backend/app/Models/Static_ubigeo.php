<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Static_ubigeo extends Model
{
    //
    protected $table = 'static_ubigeo';
    protected $primaryKey = 'id';
    protected $fillable = [
        'departamento',
        'provincia',
        'distrito',
    ];
}
