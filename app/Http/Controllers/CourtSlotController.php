<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourtSlotRequest;
use App\Services\Impl\CourtSlotService;
use App\Models\courtSlot;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CourtSlotController extends Controller
{
    use ApiResponse;

    private CourtSlotService $courtSlotService;

    public function __construct(CourtSlotService $courtSlotService) {
        $this->courtSlotService = $courtSlotService;
    }

    public function index(): JsonResponse {
        return $this->successResponse($this->courtSlotService->show(), "List of Courts");
    }

    public function store(CourtSlotRequest $request): JsonResponse {
        return $this->successResponse($this->courtSlotService->add($request), "Saved Court");
    }

    public function findById(string $id): JsonResponse {
        return $this->successResponse($this->courtSlotService->findById($id), "Court by ID");
    }

    public function update(string $id, CourtSlotRequest $request): JsonResponse {
        $data = $this->courtSlotService->update($id, $request);
        if (!$data) {
            return $this->errorResponse("Updated Court Slot Failed", 500);
        }
        return $this->successResponse($data, "Updated Court Slot by ID", 200);
    }

    public function delete(string $id): JsonResponse {
        $data = $this->courtSlotService->delete($id);
        if (!$data) {
            return $this->errorResponse("Deleted Court Failed", 500);
        }
        return $this->successResponse($data, "Deleted Court Slot by ID");
    }
}
