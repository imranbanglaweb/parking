<?php

namespace App\Models;

use App\Events\Voyager\SettingUpdated;

class Setting extends BaseModel
{
    protected $table = 'settings';

    protected $guarded = [];

    public $timestamps = false;

    protected $dispatchesEvents = [
        'updating' => SettingUpdated::class,
    ];
}
