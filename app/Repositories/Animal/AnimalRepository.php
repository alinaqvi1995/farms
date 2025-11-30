<?php

namespace App\Repositories\Animal;

use App\Models\Animal;
use Illuminate\Support\Facades\Auth;

class AnimalRepository implements AnimalRepositoryInterface
{
    public function all()
    {
        $currentUser = Auth::user();
        $query = Animal::with('farm');

        if ($currentUser && $currentUser->hasRole('farm_admin')) {
            $query->where('farm_id', $currentUser->farm_id);
        }

        return $query->get();
    }

    public function find(int $id): ?Animal
    {
        return Animal::with('farm')->find($id);
    }

    public function create(array $data): Animal
    {
        return Animal::create($data);
    }

    public function update(Animal $animal, array $data): Animal
    {
        $animal->update($data);
        return $animal;
    }

    public function delete(Animal $animal): bool
    {
        $animal->users()->delete();
        return $animal->delete();
    }
}
