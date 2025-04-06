<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use App\Services\UserServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;


class UserService implements UserServiceInterface
{
    use ApiResponse;

    private UserRepositoryInterface $UserRepository;

    public function __construct(UserRepositoryInterface $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    /**
     * @param Request $request
     * @return User
     */
    public function getCurrentUser(Request $request): User
    {
        return $request->user();
    }
}
