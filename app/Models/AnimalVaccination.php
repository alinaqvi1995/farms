<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalVaccination extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'animal_id', 'farm_id', 'vaccine_name', 'date_given',
        'next_due_date', 'dose', 'administered_by', 'notes', 'created_by'
    ];

    protected $casts = [
        'date_given' => 'datetime',
        'next_due_date' => 'datetime',
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
