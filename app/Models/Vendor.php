<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\LogsActivity;

class Vendor extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'phone',
        'address',
    ];

    public function farms(): BelongsToMany
    {
        return $this->belongsToMany(Farm::class, 'farm_vendor');
    }

    public function milkSales(): HasMany
    {
        return $this->hasMany(MilkSale::class);
    }
}
