<?php
namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilkProduction extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'animal_id',
        'farm_id',
        'session',
        'litres',
        'recorded_at',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getRecordedAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('d M, Y h:ia') : '-';
    }

    public function getCreatedAtAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('d M, Y h:ia') : '-';
    }

}
