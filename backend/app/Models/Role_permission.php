<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role_permission extends Model
{
    protected $table = 'role_permission';
    protected $fillable = ['id_role','menu','view', 'create', 'edit', 'delete'];
}
