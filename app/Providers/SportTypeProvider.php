<?php

namespace App\Providers;

use App\Repository\Impl\SportTypeRepository;
use App\Repository\ISportTypeRepository;
use App\Services\Impl\SportTypeService;
use App\Services\ISportTypeService;

class SportTypeProvider extends AppServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ISportTypeRepository::class, SportTypeRepository::class);
        $this->app->bind(ISportTypeService::class, SportTypeService::class);
    }

    public function boot(): void
    {
        //
    }
}
