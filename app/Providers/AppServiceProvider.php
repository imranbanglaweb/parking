<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(VoyagerServiceProvider::class);

    }

    /**
     * @param Router $router
     * @param Dispatcher $event
     */
   public function boot()
    {
        //  error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
        Schema::defaultStringLength(191);
    }
}
