<?php

namespace App\Events\Voyager;

use Illuminate\Queue\SerializesModels;

class TableUpdated
{
    use SerializesModels;

    public $name;

    public function __construct(array $name)
    {
        $this->name = $name;

        event(new TableChanged($name['name'], 'Updated'));
    }
}
