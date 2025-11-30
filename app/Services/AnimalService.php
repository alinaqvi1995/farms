<?php

namespace App\Services;

use App\Models\Animal;
use App\Repositories\Animal\AnimalRepositoryInterface;

class AnimalService
{
    protected $repo;

    public function __construct(AnimalRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function list()
    {
        return $this->repo->all();
    }

    public function create(array $data): Animal
    {
        return $this->repo->create($data);
    }

    public function update(Animal $animal, array $data): Animal
    {
        return $this->repo->update($animal, $data);
    }

    public function delete(Animal $animal): bool
    {
        return $this->repo->delete($animal);
    }
}
