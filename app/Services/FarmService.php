<?php

namespace App\Services;

use App\Models\Farm;
use App\Repositories\Farm\FarmRepositoryInterface;

class FarmService
{
    protected $repo;

    public function __construct(FarmRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function list()
    {
        return $this->repo->all();
    }

    public function find(int $id): ?Farm
    {
        return $this->repo->find($id);
    }

    public function create(array $data): Farm
    {
        return $this->repo->create($data);
    }

    public function update(Farm $farm, array $data): Farm
    {
        return $this->repo->update($farm, $data);
    }

    public function delete(Farm $farm): bool
    {
        return $this->repo->delete($farm);
    }
}
