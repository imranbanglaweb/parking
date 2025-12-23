<?php

namespace App\Events\Voyager;

class FileDeleted
{
    public $path;

    public function __construct($path)
    {
        $this->path;
    }
}
