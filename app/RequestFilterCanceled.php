<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestFilterCanceled extends Model
{
    protected $table = 'request_filter_canceled'; 

   	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'request_id','provider_id', 'estimated_fare', 's_latitude', 's_longitude', 'p_latitude', 'p_longitude', 'p_distance', 'unit',
    ];

    /**
     * The services that belong to the user.
     */
    public function request()
    {
        return $this->belongsTo('App\UserRequests');
    }


    /**
     * The provider assigned to the request.
     */
    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }
}
