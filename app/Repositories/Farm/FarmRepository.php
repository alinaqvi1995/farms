<?php

namespace App\Repositories\Farm;

use App\Models\Farm;

class FarmRepository implements FarmRepositoryInterface
{
    public function all()
    {
        return Farm::with('users')->get();
    }

    public function find(int $id): ?Farm
    {
        return Farm::with('users', 'animals')->find($id);
    }

    public function create(array $data): Farm
    {
        return Farm::create($data);
    }

    public function update(Farm $farm, array $data): Farm
    {
        $farm->update($data);
        return $farm;
    }

    public function delete(Farm $farm): bool
    {
        $farm->users()->delete();
        return $farm->delete();
    }
}
