<?php
namespace App\Services;

use App\Http\Requests\VenueRequest;
use App\Models\Venue;

interface IVenueService
{
    public function show(int $perPage);
    public function findById(string $id): ?Venue;
    public function add(VenueRequest $request): Venue;
    public function update(string $id, VenueRequest $request): ?Venue;
    public function delete(string $id): ?Venue;
}
