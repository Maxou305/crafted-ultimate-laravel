<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderProduct extends Model
{
    use HasFactory;
    use HasUuids;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): HasMany
    {
        return $this->HasMany(Product::class);
    }
}
