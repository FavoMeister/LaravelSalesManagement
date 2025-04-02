<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
    public function products(){
        return $this->hasMany('App\Models\Products');
    }
}
