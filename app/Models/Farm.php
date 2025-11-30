<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class Farm extends Model
{
    use LogsActivity, HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'owner_name',
        'phone',
        'email',
        'address',
        'city',
        'state',
        'country',
        'zipcode',
        'area',
        'description',
        'animals_count',
        'animal_types',
        'registration_number',
        'established_at',
        'status',
        'notes',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    // Milk productions (through animals)
    public function milkProductions()
    {
        return $this->hasManyThrough(
            \App\Models\MilkProduction::class,
            \App\Models\Animal::class,
            'farm_id', // Foreign key on animals table
            'animal_id', // Foreign key on milk_productions table
            'id', // Local key on farms table
            'id' // Local key on animals table
        );
    }

    // Animal reproductions (through animals)
    public function reproductions()
    {
        return $this->hasManyThrough(
            \App\Models\AnimalReproduction::class,
            \App\Models\Animal::class,
            'farm_id',
            'animal_id',
            'id',
            'id'
        );
    }

    // Calves (through animals)
    public function calves()
    {
        return $this->hasManyThrough(
            \App\Models\Calf::class,
            \App\Models\Animal::class,
            'farm_id',
            'mother_id',
            'id',
            'id'
        );
    }

    // Health checks (through animals)
    public function healthChecks()
    {
        return $this->hasManyThrough(
            \App\Models\AnimalHealthCheck::class,
            \App\Models\Animal::class,
            'farm_id',
            'animal_id',
            'id',
            'id'
        );
    }

    // Vaccinations (through animals)
    public function vaccinations()
    {
        return $this->hasManyThrough(
            \App\Models\AnimalVaccination::class,
            \App\Models\Animal::class,
            'farm_id',
            'animal_id',
            'id',
            'id'
        );
    }

    // Treatments (through animals)
    public function treatments()
    {
        return $this->hasManyThrough(
            \App\Models\AnimalTreatment::class,
            \App\Models\Animal::class,
            'farm_id',
            'animal_id',
            'id',
            'id'
        );
    }

    // Diseases (through animals)
    public function diseases()
    {
        return $this->hasManyThrough(
            \App\Models\AnimalDisease::class,
            \App\Models\Animal::class,
            'farm_id',
            'animal_id',
            'id',
            'id'
        );
    }

    // Feed inventory (directly on farm)
    public function feedInventories()
    {
        return $this->hasMany(\App\Models\FeedInventory::class);
    }
}
