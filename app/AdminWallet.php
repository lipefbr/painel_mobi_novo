<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminWallet extends Model
{
    protected $table='admin_wallet';
    use SoftDeletes;
    
	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
    protected $fillable = [
        'transaction_id',       
        'transaction_alias',
        'transaction_desc',        
        'type',
        'amount',
        'open_balance',
        'close_balance',
        'form_of_payment',
        'category_id',
        'payment_date',
        'editable',
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


    public function category()
    {
      return $this->hasOne(PaymentCategory::class, 'id', 'category_id');
    }
}
