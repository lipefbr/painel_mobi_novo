<?php
namespace App\Traits;

use App\Scopes\FleetScope;
use Auth;


trait AutoFleet
{
 	protected static function boot()
    {
        parent::boot();
 
        static::addGlobalScope(new FleetScope);
    }

}