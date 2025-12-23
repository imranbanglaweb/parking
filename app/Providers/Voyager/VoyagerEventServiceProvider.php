<?php

namespace App\Providers\Voyager;

use App\Events\Voyager\BreadAdded;
use App\Events\Voyager\BreadDeleted;
use App\Events\Voyager\SettingUpdated;
use App\Listeners\Voyager\AddBreadMenuItem;
use App\Listeners\Voyager\AddBreadPermission;
use App\Listeners\Voyager\ClearCachedSettingValue;
use App\Listeners\Voyager\DeleteBreadMenuItem;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class VoyagerEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        BreadAdded::class => [
            AddBreadMenuItem::class,
            AddBreadPermission::class,
        ],
        BreadDeleted::class => [
            DeleteBreadMenuItem::class,
        ],
        SettingUpdated::class => [
            ClearCachedSettingValue::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
