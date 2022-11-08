<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoFleet;

class FleetWallet extends Model
{
    protected $table='fleet_wallet';

    use AutoFleet;
    
   	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = [
        'fleet_id',        
        'transaction_id',        
        'transaction_alias',
        'transaction_desc',
        'type',
        'amount',
        'open_balance',
        'close_balance',
        'is_real',
        'commission',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at'
    ];
}
