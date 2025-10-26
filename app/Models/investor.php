<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class investor extends Model
{
    protected $fillable = [
        'name',
        'percentage',
        'dapur_id',
    ];
    public function dapur()
    {
        return $this->belongsTo(Dapur::class, 'dapur_id');
    }
}
