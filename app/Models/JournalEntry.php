<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $fillable = [
        'journal_id',
        'account_id',
        'type',   // debit atau credit
        'qty',
        'unit',
        'price',
        'total',
        'date',
        'journalable_id',
        'journalable_type',
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function journalable()
    {
        return $this->morphTo();
    }

    // public function dapur()
    // {
    //     return $this->hasOneThrough(
    //         Dapur::class, // Model tujuan
    //         Journal::class, // Model perantara
    //         'id', // Foreign key di table `journals` ke `journal_entries`? (cek dulu)
    //         'id', // Foreign key di table `dapur` (biasanya `id`)
    //         'journal_id', // Foreign key di table `journal_entries`
    //         'dapur_id' // Foreign key di table `journals`
    //     );
    // }
}
