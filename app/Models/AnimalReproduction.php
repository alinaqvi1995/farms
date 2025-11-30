<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalReproduction extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'animal_id', 'farm_id', 'type', 'event_date',
        'male_animal_id', 'semen_batch', 'pregnancy_result',
        'calf_tag', 'calf_gender', 'notes', 'created_by'
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function maleAnimal()
    {
        return $this->belongsTo(Animal::class, 'male_animal_id');
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
