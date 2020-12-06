<?php

namespace App\Providers;

use App\Services\SWService;
use App\Services\SWServiceInterface;
use Illuminate\Support\ServiceProvider;

class SWServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SWServiceInterface::class, SWService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
