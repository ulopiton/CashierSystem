<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'stock',
        'image',
    ];

    public function category(): BelongsTo{
      return $this->belongsTo(Category::class);
    }
    public function orderDetails(): HasMany{
      return $this->hasMany(OerderDetail::class);
    }
    public function transactionDetails(): HasMany{
      return $this->hasMany(TransactionDetail::class);
    }
}
