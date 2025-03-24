<?php

namespace App\Services;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function login(LoginRequest $request);

    public function register(RegisterRequest $request): void;

    public function verifyEmail(Request $request);
}
