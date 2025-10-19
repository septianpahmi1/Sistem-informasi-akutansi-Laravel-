<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyIn extends Model
{
    protected $fillable = [
        'inventory_id',
        'date',
        'proof_number',
        'qty',
        'price',
        'total',
    ];

    public function InventoryIn()
    {
        return $this->belongsTo(Inventory::class, 'inventry_id');
    }
}
