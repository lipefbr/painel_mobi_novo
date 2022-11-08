<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentCategory extends Model
{
    //use SoftDeletes;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'id',
            'name',
            'type',
            'color',
            'parent_id',
            'status',
            'blocked'
    ];

    public function sub()
    {
      return $this->hasMany(PaymentCategory::class, 'parent_id');
    }
}
