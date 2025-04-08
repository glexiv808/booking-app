<?php

namespace App\Http\Controllers;

use App\Http\Requests\VenueRequest;
use App\Services\Impl\VenueService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Services\IVenueService;

class VenueController extends Controller
{
    use ApiResponse;

    private VenueService $venueService;

    public function __construct(VenueService $venueService) {
        $this->venueService = $venueService;
    }

    public function index(): JsonResponse {
        return $this->successResponse($this->venueService->show(), "List of Venues");
    }

    public function store(VenueRequest $request): JsonResponse {
        return $this->successResponse($this->venueService->add($request), "Saved Venue");
    }

    public function findById(string $id): JsonResponse {
        return $this->successResponse($this->venueService->findById($id), "Venue by ID");
    }

    public function update(string $id, VenueRequest $request): JsonResponse {
        $data = $this->venueService->update($id, $request);
        if (!$data) {
            return $this->errorResponse("Updated Venue Failed", 500);
        }
        return $this->successResponse($data, "Updated Venue by id", 200);
    }

    public function delete(string $id): JsonResponse {
        $data = $this->venueService->delete($id);
        if (!$data) {
            return $this->errorResponse("Deleted Venue Failed", 500);
        }
        return $this->successResponse($data, "Deleted Venue by id");
    }
}
