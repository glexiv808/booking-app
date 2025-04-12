<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourtRequest;
use App\Services\Impl\CourtService;
use App\Models\Court;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CourtController extends Controller
{
    use ApiResponse;

    private CourtService $courtService;

    public function __construct(CourtService $courtService) {
        $this->courtService = $courtService;
    }

    public function index(): JsonResponse {
        return $this->successResponse($this->courtService->show(), "List of Courts");
    }

    public function store(CourtRequest $request): JsonResponse {
        return $this->successResponse($this->courtService->add($request), "Saved Court");
    }

    public function findById(string $id): JsonResponse {
        return $this->successResponse($this->courtService->findById($id), "Court by ID");
    }

    public function update(string $id, CourtRequest $request): JsonResponse {
        $data = $this->courtService->update($id, $request);
        if (!$data) {
            return $this->errorResponse("Updated Court Failed", 500);
        }
        return $this->successResponse($data, "Updated Court by ID", 200);
    }

    public function delete(string $id): JsonResponse {
        $data = $this->courtService->delete($id);
        if (!$data) {
            return $this->errorResponse("Deleted Court Failed", 500);
        }
        return $this->successResponse($data, "Deleted Court by ID");
    }
}
