<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyOut extends Model
{
    protected $fillable = [
        'inventory_id',
        'date',
        'proof_number',
        'qty',
        'price',
        'total',
    ];

    public function InventoryOut()
    {
        return $this->belongsTo(Inventory::class, 'inventry_id');
    }
}
