<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['title', 'state_id','lat','longi', 'iso_ddd', 'state_id'];


    public function state()
    {
        return $this->hasOne(State::class, 'id',  'state_id');
    }

}
