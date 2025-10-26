<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dapur extends Model
{
    protected $fillable = [
        'name',
        'address',
    ];

    public function journalid()
    {
        return $this->hasMany(Journal::class);
    }
    public function investorid()
    {
        return $this->hasMany(investor::class);
    }
}
