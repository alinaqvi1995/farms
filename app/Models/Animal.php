<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class Animal extends Model
{
    use LogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'farm_id',
        'tag_number',
        'name',
        'type',
        'breed',
        'birth_date',
        'gender',
        'color',
        'source',
        'purchase_price',
        'purchase_date',
        'vendor',
        'health_status',
        'notes',
        'city',
        'state',
        'area',
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function milkProductions()
    {
        return $this->hasMany(MilkProduction::class);
    }

    public function reproductions()
    {
        return $this->hasMany(AnimalReproduction::class);
    }

    public function calves()
    {
        return $this->hasMany(Calf::class, 'mother_id');
    }

    public function healthChecks()
    {
        return $this->hasMany(AnimalHealthCheck::class);
    }

    public function vaccinations()
    {
        return $this->hasMany(AnimalVaccination::class);
    }

    public function treatments()
    {
        return $this->hasMany(AnimalTreatment::class);
    }

    public function diseases()
    {
        return $this->hasMany(AnimalDisease::class);
    }

    public function feedInventories()
    {
        return $this->farm ? $this->farm->feedInventories() : null;
    }
}
