<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalTreatment extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'animal_id', 'farm_id', 'treatment_type', 'treatment_date',
        'given_by', 'medicine', 'dosage', 'duration',
        'notes', 'created_by'
    ];

    protected $casts = [
        'treatment_date' => 'datetime',
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
