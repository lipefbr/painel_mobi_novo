<?php

namespace App;

use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use NotificationChannels\WebPush\HasPushSubscriptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasPushSubscriptions;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'mobile', 'password', 'active', 'cpf', 'city_id', 'parent_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];




    public function fleets()
    {
       return $this->belongsToMany(Fleet::class, 'admin_fleets', 'admin_id', 'fleet_id');
    }


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }

    public function setMobileAttribute($value)
    {
        return $this->attributes['mobile'] = str_replace(['(', ')', '-', ' '], '', $value);
    }

    public function getMobileAttribute()
    {
        return mask("(##) # ####-####", str_replace(['(', ')', '-', ' '], '', $this->attributes['mobile']));
    }

    public function isSuperAdmin(){
        return (boolean)  $this->roles()->find(1);
    }

    public function isAdmin(){
        return (boolean)    $this->roles()->find(2);
    }

    public function isFleetManage(){
        return (boolean) $this->roles()->find(6);
    }


    public function isParentUser(){
        return (boolean) ($this->roles()->find(3) || $this->roles()->find(4) || $this->roles()->find(5));
    }

}
