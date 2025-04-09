<?php
namespace App\Services;

use App\Http\Requests\LocationServiceRequest;
use App\Models\LocationService;

/**
 * Interface ILocationServiceService
 *
 * Defines the contract for managing LocationServices, including
 * retrieving, creating, updating, and deleting LocationServices.
 */
interface ILocationServiceService
{
    /**
     * Get a paginated list of LocationServices.
     *
     * @param int $perPage Number of items per page
     * @return mixed Paginated list of LocationServices
     */
    public function show(int $perPage);

    /**
     * Find a LocationService by its ID.
     *
     * @param int $id LocationService UUID
     * @return LocationService|null LocationService object or null if not found
     */
    public function findById(int $id): ?LocationService;

    /**
     * Create and store a new LocationService.
     *
     * @param LocationServiceRequest $request The validated request data
     * @return LocationService The created LocationService
     */
    public function add(LocationServiceRequest $request): LocationService;

    /**
     * Update a LocationService by its ID.
     *
     * @param int $id LocationService UUID
     * @param LocationServiceRequest $request The validated request data
     * @return LocationService|null The updated LocationService or null if not found
     */
    public function update(int $id, LocationServiceRequest $request): ?LocationService;

    /**
     * Delete a LocationService by its ID.
     *
     * @param int $id LocationService UUID
     * @return LocationService|null The deleted LocationService or null if not found
     */
    public function delete(int $id): ?LocationService;
}
