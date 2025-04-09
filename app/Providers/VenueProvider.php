<?php

namespace App\Providers;

use App\Repository\Impl\VenueRepository;
use App\Repository\IVenueRepository;
use App\Services\Impl\VenueService;
use App\Services\IVenueService;
use Illuminate\Support\ServiceProvider;

class VenueProvider extends ServiceProvider
{
    public function register():void
    {
        $this->app->bind(IVenueRepository::class, VenueRepository::class);
        $this->app->bind(IVenueService::class, VenueService::class);
    }

    public function boot(): void
    {
        //
    }
}
