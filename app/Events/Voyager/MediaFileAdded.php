<?php

namespace App\Events\Voyager;

use Illuminate\Queue\SerializesModels;

class MediaFileAdded
{
    use SerializesModels;

    public $path;

    public function __construct($path)
    {
        $this->path = $path;
    }
}
