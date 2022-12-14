<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoFleet;

class ServiceType extends Model
{
    use AutoFleet;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fleet_id',
        'name',
        'provider_name',
        'image',
        'marker',
        'price',
        'min_price',
        'fixed',
        'description',
        'status',
        'minute',
        'hour',
        'distance',
        'calculator',
        'capacity',
        'service_type_vehicle',
        'waiting_free_mins',
        'waiting_min_charge'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'created_at', 'updated_at'
    ];

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }
}
