<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalDisease extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'animal_id', 'farm_id', 'disease_name',
        'diagnosed_date', 'recovered_date', 'status',
        'symptoms', 'notes', 'created_by'
    ];

    protected $casts = [
        'diagnosed_date' => 'datetime',
        'recovered_date' => 'datetime',
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
