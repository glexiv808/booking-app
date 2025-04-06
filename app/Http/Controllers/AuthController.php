<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorException;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\IAuthService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthController extends Controller
{
    use ApiResponse;

    private IAuthService $authService;

    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login user and create token.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws UnauthorizedException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->successResponse($this->authService->login($request), 'Login successful');
    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $this->authService->register($request);

        return $this->successResponse(
            [],
            'User registered successfully. Please check your email to verify your account.',
            201
        );
    }

    /**
     * Logout user (revoke the token).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            // Revoke the current access token
            $request->user()->currentAccessToken()->delete();

            return $this->successResponse(null, 'Successfully logged out');
        } catch (Exception $e) {
            return $this->errorResponse('Logout failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Verify email with token.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ErrorException
     */
    public function verifyEmail(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        return $this->successResponse(
            $this->authService->verifyEmail($request),
            'Email verified successfully'
        );
    }
}
