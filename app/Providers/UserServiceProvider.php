<?php

namespace App\Providers;

use App\Repository\Impl\UserRepository;
use App\Repository\Impl\VerifyCodeRepository;
use App\Repository\IUserRepository;
use App\Repository\IVerifyCodeRepositoryInterface;
use App\Services\IAuthService;
use App\Services\Impl\AuthService;
use App\Services\Impl\UserService;
use App\Services\IUserService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IUserRepository::class,UserRepository::class);
        $this->app->bind(IUserService::class,UserService::class);
        $this->app->bind(IAuthService::class,AuthService::class);
        $this->app->bind(IVerifyCodeRepositoryInterface::class,VerifyCodeRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
