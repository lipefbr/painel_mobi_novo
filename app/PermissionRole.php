<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
	public $timestamps = false;

    protected $fillable = [
        'permission_id', 'role_id'
    ];
}
