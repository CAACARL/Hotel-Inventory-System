<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'item_id',
        'user_id',
        'type',
        'transaction_type',
        'quantity',
        'notes',
        'reference_number',
        'transaction_date',
    ];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'datetime',
        ];
    }

    /**
     * Get the item that owns the transaction.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
