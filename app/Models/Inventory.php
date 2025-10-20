<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'code',
        'name',
        'unit',
    ];
    public function stockIn()
    {
        return $this->hasMany(SupplyIn::class);
    }

    public function stockOut()
    {
        return $this->hasMany(SupplyOut::class);
    }

    public function getCurrentStockAttribute()
    {
        $in = $this->stockIn()->sum('qty');
        $out = $this->stockOut()->sum('qty');
        return $in - $out;
    }
}
