<?php

namespace App\Listeners\Voyager;

use App\Events\Voyager\SettingUpdated;
use Cache;

class ClearCachedSettingValue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * handle.
     *
     * @param SettingUpdated $event
     *
     * @return void
     */
    public function handle(SettingUpdated $event)
    {
        if (config('voyager.settings.cache', false) === true) {
            Cache::tags('settings')->forget($event->setting->key);
        }
    }
}
