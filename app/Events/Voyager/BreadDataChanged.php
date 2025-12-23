<?php

namespace App\Events\Voyager;

use App\Models\DataType;
use Illuminate\Queue\SerializesModels;

class BreadDataChanged
{
    use SerializesModels;

    public $dataType;

    public $data;

    public $changeType;

    public function __construct(DataType $dataType, $data, $changeType)
    {
        $this->dataType = $dataType;

        $this->data = $data;

        $this->changeType = $changeType;
    }
}
