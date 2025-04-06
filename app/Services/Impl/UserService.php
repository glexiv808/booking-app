<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Repository\IUserRepository;
use App\Services\IUserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;


class UserService implements IUserService
{
    use ApiResponse;

    private IUserRepository $UserRepository;

    public function __construct(IUserRepository $UserRepository)
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
