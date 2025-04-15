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

    // One to Many (Inverse)
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    // Many to Many
    public function sales() {
        return $this->belongsToMany(Sale::class, 'product_sales', 'product_id', 'sale_id')
               ->withPivot('quantity', 'price', 'discount');
    }
}
