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

    /**
     * 
     * Scopes
     * 
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeWithLastSale($query)
    {
        return $query->addSelect([
            'last_sale' => Sale::select('sale_date')
                ->whereColumn('client_id', 'clients.id')
                ->latest()
                ->limit(1)
        ]);
    }

    /*public function scopeWithPurchaseCount($query)
    {
        return $query->addSelect([
            'purchase_count' => Sale::select('id')
                ->whereColumn('client_id', 'clients.id')
                ->count()
        ]);
    }*/
    public function scopeWithPurchaseCount($query)
    {
        return $query->withCount(['sales as purchase_count']);
    }
}
