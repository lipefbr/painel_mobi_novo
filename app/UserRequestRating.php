<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoFleet;

class UserRequestRating extends Model
{

    use AutoFleet;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_id',
        'user_id',
        'request_id',
        'provider_rating',
        'user_rating',
        'provider_comment',
        'user_comment',
        'fleet_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
         'created_at', 'updated_at'
    ];

    /**
     * The user who created the request.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * The provider assigned to the request.
     */
    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }
}
