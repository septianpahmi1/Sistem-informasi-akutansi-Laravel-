<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class investor extends Model
{
    protected $fillable = [
        'name',
        'percentage'
    ];
}
