<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model{
    protected $fillable = [
        'invoice_number',
        'total_amount',
        'payment_amount',
        'change_amount',
    ];
    public function details(): HasMany{
        return $this->hasMany(TransactionDetail::class);
    }
}