<?php

namespace App\Services\Impl;

use App\Http\Requests\SportTypeRequest;
use App\Models\SportType;
use App\Repository\ISportTypeRepository;
use App\Services\ISportTypeService;
use App\Traits\ApiResponse;

class SportTypeService implements ISportTypeService
{
    use ApiResponse;
    private ISportTypeRepository $repository;

    public function __construct(ISportTypeRepository $repository){
        $this->repository = $repository;
    }


    public function show(): array
    {
        return $this->repository->show();
    }

    public function findById(int $id): ?SportType
    {
        return $this->repository->getById($id);
    }

    public function add(SportTypeRequest $request): SportType
    {
        $data = [
          'name' => $request->get('name'),
          'description' => $request->get('description'),
        ];
        return $this->repository->store($data);
    }

    public function update(int $id, SportTypeRequest $request): ?SportType
    {
        $data = [
            'name' => $request->get('name'),
            'description' => $request->get('description')
        ];
        return $this->repository->update($data, $id);
    }

    public function delete(int $id): ?SportType
    {
        return $this->repository->delete($id);
    }
}
