<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'entry_type',
        'quantity',
        'feed_name',
        'cost_per_unit',
        'vendor',
        'date',
        'remarks'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    // Helper to get current stock for the farm
    public static function currentStock($farmId)
    {
        return self::where('farm_id', $farmId)
            ->selectRaw("
                SUM(CASE WHEN entry_type = 'stock_in' THEN quantity ELSE 0 END) -
                SUM(CASE WHEN entry_type = 'consumption' THEN quantity ELSE 0 END)
                AS total_stock
            ")
            ->value('total_stock');
    }
}
