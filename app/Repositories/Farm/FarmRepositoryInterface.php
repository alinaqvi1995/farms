<?php

namespace App\Repositories\Farm;

use App\Models\Farm;

interface FarmRepositoryInterface
{
    public function all();
    public function create(array $data): Farm;
    public function find(int $id): ?Farm;
    public function update(Farm $farm, array $data): Farm;
    public function delete(Farm $farm): bool;
}
