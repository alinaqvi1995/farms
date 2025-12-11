<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\LogsActivity;

class MilkSale extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'farm_id',
        'vendor_id',
        'quantity',
        'price_type',
        'price_per_unit',
        'total_amount',
        'sold_at',
        'notes',
    ];

    protected $casts = [
        'sold_at' => 'datetime',
        'quantity' => 'decimal:2',
        'price_per_unit' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
