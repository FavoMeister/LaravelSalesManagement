<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'category_id',
        'code',
        'description',
        'stock',
        'code',
        'purchase_price',
        'selling_price',
        'image',
        'sale',
        'added_date',
        'status',
    ];

    public $timestamps = true;

    /*
     * Relationships
     */
}
