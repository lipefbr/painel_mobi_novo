<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable,HasPushSubscriptions;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city_id','first_name', 'last_name', 'cpf', 'gender', 'email', 'mobile', 'picture', 'password', 'device_type','device_token','login_by', 'payment_mode','social_unique_id','device_id','wallet_balance','referral_unique_id', 'user_type','qrcode_url','country_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at'
    ];


    /**
     * The services that belong to the user.
     */
    public function trips()
    {
        return $this->hasMany('App\UserRequests','user_id','id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFirstNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }

    public function getLastNameAttribute($value)
    {
        return ucwords(strtolower($value));
    }


    public function setMobileAttribute($value)
    {
        return $this->attributes['mobile'] = str_replace(['(', ')', '-', ' '], '', $value);
    }

    public function getMobileAttribute()
    {
        return mask("(##) # ####-####", str_replace(['(', ')', '-', ' '], '', $this->attributes['mobile']));
    }
}
