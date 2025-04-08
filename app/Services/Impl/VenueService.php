<?php
namespace App\Services\Impl;

use App\Http\Requests\VenueRequest;
use App\Models\Venue;
use App\Repository\IVenueRepository;
use App\Services\IVenueService;
use Illuminate\Support\Str;
use MatanYadaev\EloquentSpatial\Objects\Point;

class VenueService implements IVenueService
{
    private IVenueRepository $repository;

    public function __construct( IVenueRepository $repository) {
        $this->repository = $repository;
    }

    public function show(int $perPage) {
        return $this->repository->show($perPage);
    }

    public function findById(string $id): ?Venue {
        return $this->repository->getById($id);
    }

    public function add(VenueRequest $request): Venue {
        $data = [
            'venue_id' => Str::uuid(),
            'owner_id' => $request->user()->uuid,
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'longitude' => $request->get('longitude'),
            'latitude' => $request->get('latitude'),
            'coordinates' => new Point($request->get('latitude'), $request->get('longitude'),),
            'status' => $request->get('status'),
          ];
        return $this->repository->store($data);
    }

    public function update(string $id, VenueRequest $request): ?Venue {
        $data = [
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'longitude' => $request->get('longitude'),
            'latitude' => $request->get('latitude'),
            'coordinates' => new Point($request->get('latitude'), $request->get('longitude'),),
            'status' => $request->get('status'),
          ];
        return $this->repository->update($data, $id);
    }

    public function delete(string $id): ?Venue {
        return $this->repository->delete($id);
    }
}
