<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'status',
    ];

    public $timestamps = true;

    /*
     * Relationships
     */

    // One to Many
    public function users(){
        return $this->hasMany('App\Models\User');
    }

     // One to Many
     public function sales(){
        return $this->hasMany('App\Models\Sale');
    }
}
