<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $fillable = ['name', 'fl_no_view_dashboard'];
}
