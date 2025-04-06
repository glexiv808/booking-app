<?php

namespace App\Providers;

use App\Repository\Impl\UserRepository;
use App\Repository\Impl\VerifyCodeRepository;
use App\Repository\IVerifyCodeRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Services\AuthServiceInterface;
use App\Services\Impl\AuthService;
use App\Services\Impl\UserService;
use App\Services\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
        $this->app->bind(UserServiceInterface::class,UserService::class);
        $this->app->bind(AuthServiceInterface::class,AuthService::class);
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
