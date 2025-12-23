<?php

namespace App\Events\Voyager;

use App\Models\DataType;
use Illuminate\Queue\SerializesModels;

class BreadDataRestored
{
    use SerializesModels;

    public $dataType;

    public $data;

    public function __construct(DataType $dataType, $data)
    {
        $this->dataType = $dataType;

        $this->data = $data;

        event(new BreadDataChanged($dataType, $data, 'Restored'));
    }
}
