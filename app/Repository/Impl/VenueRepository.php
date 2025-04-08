<?php

namespace App\Repository\Impl;

use App\Models\Venue;
use App\Repository\IVenueRepository;

class VenueRepository implements IVenueRepository
{
    public function show(int $perPage) {
        return Venue::paginate($perPage);
    }

    public function getById(string $id) {
        return Venue::where('venue_id', $id)->first();
    }

    public function store(array $data) {
        return Venue::create($data);
    }

    public function update(array $data, string $id) {
        $venue = Venue::where('venue_id', $id)->first();
        if (!$venue) return null;

        $venue->update($data);
        return $venue;
    }

    public function delete(string $id) {
        $venue = Venue::where('venue_id', $id)->first();
        if (!$venue) return null;

        $venue->delete();
        return $venue;
    }
}

