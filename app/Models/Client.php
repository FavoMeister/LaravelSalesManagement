<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'document',
        'email',
        'phone',
        'direction',
        'birth_date',
        'status',
    ];

    public $timestamps = true;

    /*
     * Relationships
    */

    // One to Many
    public function sales(){
        return $this->hasMany('App\Models\Sale');
    }
}
