<?php
namespace App\Services\Impl;

use App\Http\Requests\LocationServiceRequest;
use App\Models\LocationService;
use App\Repository\ILocationServiceRepository;
use App\Services\ILocationServiceService;
use Illuminate\Support\Str;

class LocationServiceService implements ILocationServiceService
{
    private ILocationServiceRepository $repository;

    public function __construct(ILocationServiceRepository $repository) {
        $this->repository = $repository;
    }

    public function show(int $perPage) {
        return $this->repository->show($perPage);
    }

    public function findById(int $id): ?LocationService {
        return $this->repository->getById($id);
    }

    public function add(LocationServiceRequest $request): LocationService {
        $data = [
            'venue_id' => $request->get('venue_id'),
            'service_name' => $request->get('service_name'),
            'price' => $request->get('price'),
            'is_available' => $request->get('is_available'),
            'description' => $request->get('description'),
        ];
        return $this->repository->store($data);
    }

    public function update(int $id, LocationServiceRequest $request): ?LocationService {
        $data = [
            'venue_id' => $request->get('venue_id'),
            'service_name' => $request->get('service_name'),
            'price' => $request->get('price'),
            'is_available' => $request->get('is_available'),
            'description' => $request->get('description'),
        ];
        return $this->repository->update($data, $id);
    }

    public function delete(int $id): ?LocationService {
        return $this->repository->delete($id);
    }
}
