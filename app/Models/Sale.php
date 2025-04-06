<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'payment_method',
        'tax',
        'net_tax',
        'total',
        'sale_date',
        'status',
        'branch_id',
        'client_id',
        'seller_id',
    ];

    public $timestamps = true;

    /*
     * Relationships
    */

    // One to Many (Inverse)
    public function branch(){
        return $this->belongsTo('App\Models\Branch');
    }

    // One to Many (Inverse)
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    // One to Many (Inverse)
    public function client(){
        return $this->belongsTo('App\Models\Client');
    }
}
