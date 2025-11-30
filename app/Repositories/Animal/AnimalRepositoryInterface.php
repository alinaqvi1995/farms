<?php

namespace App\Repositories\Animal;

use App\Models\Animal;

interface AnimalRepositoryInterface
{
    public function all();
    public function create(array $data): Animal;
    public function find(int $id): ?Animal;
    public function update(Animal $animal, array $data): Animal;
    public function delete(Animal $animal): bool;
}
