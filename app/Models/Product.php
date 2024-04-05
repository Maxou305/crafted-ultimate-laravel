<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'shop_id',
        'quantity',
        'image',
        'color',
        'material',
        'size',
        'story',
    ];

    public function shop() : BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
