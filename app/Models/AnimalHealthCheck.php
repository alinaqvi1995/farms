<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalHealthCheck extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'animal_id', 'farm_id', 'check_date', 'checked_by',
        'body_temperature', 'heart_rate', 'respiration_rate',
        'overall_condition', 'notes', 'created_by'
    ];

    protected $casts = [
        'check_date' => 'datetime',
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
}
