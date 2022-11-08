<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class AdminFleet extends Model
{

	protected $table = 'admin_fleets';
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = [
        'id',       
        'admin_id',
        'fleet_id'    
    ];


}
