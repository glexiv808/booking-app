<?php

namespace App\Services;
use App\Exceptions\ErrorException;
use App\Exceptions\RecordExistsException;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthUserResource;
use App\Models\User;
use Illuminate\Http\Request;

interface IUserService
{
    /**
     * Get the authenticated user's information.
     *
     * @param Request $request
     * @return User
     */
    public function getCurrentUser(Request $request): User;
}
