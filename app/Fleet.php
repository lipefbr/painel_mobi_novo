<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoFleet;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fleet extends Model
{

    use SoftDeletes;
    use AutoFleet;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city_id',
        'name', 
        'logo',
        'admin_id', 'commission'
    ];

    public function city()
    {
        return $this->belongsTo(City::class,'city_id','id');
    }

    public function services()
    {
        return $this->hasMany(ServiceType::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id', 'id');
    }
    
}
