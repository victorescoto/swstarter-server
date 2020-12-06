<?php

namespace App\Providers;

use App\Exceptions\SWSerializerNotFoundException;
use App\Serializers\SWSerializerInterface;
use Illuminate\Support\ServiceProvider;

class SWSerializerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SWSerializerInterface::class, function () {
            $resource = $this->app->make('router')->input('resource');

            return match ($resource) {
                default => throw new SWSerializerNotFoundException($resource),
            };
        });
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
