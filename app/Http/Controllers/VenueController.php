<?php

namespace App\Http\Controllers;

use App\Http\Requests\VenueRequest;
use App\Models\Venue;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use App\Services\IVenueService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class VenueController extends Controller
{
    use ApiResponse;
    use AuthorizesRequests;

    private IVenueService $venueService;

    public function __construct(IVenueService  $venueService) {
        $this->venueService = $venueService;
    }

    public function index(): JsonResponse {
        $perPage = intval(request('per_page', 2));
        $perPage = max(1, min($perPage, 20));

        return $this->successResponse($this->venueService->show($perPage),"List of Venues"
        );
    }


    public function store(VenueRequest $request): JsonResponse {
        $this->authorize('create', Venue::class);
        $user = $request->user();
        return $this->successResponse($this->venueService->add($request), "Saved Venue");
    }

    public function findById(string $id): JsonResponse {
        return $this->successResponse($this->venueService->findById($id), "Venue by ID");
    }

    public function update(string $id, VenueRequest $request): JsonResponse {
        $venue = $this->venueService->findById($id);
        $this->authorize('update', $venue);
        $data = $this->venueService->update($id, $request);
        if (!$data) {
            return $this->errorResponse("Updated Venue Failed", 500);
        }
        return $this->successResponse($data, "Updated Venue by id", 200);
    }

    public function delete(string $id): JsonResponse {
        $venue = $this->venueService->findById($id);
        $this->authorize('delete', $venue);
        $data = $this->venueService->delete($id);
        if (!$data) {
            return $this->errorResponse("Deleted Venue Failed", 500);
        }
        return $this->successResponse($data, "Deleted Venue by id");
    }
}
