<?php

namespace App\Events\Voyager;

use App\Voyager\Database\Schema\Table;
use Illuminate\Queue\SerializesModels;

class TableAdded
{
    use SerializesModels;

    public $table;

    public function __construct(Table $table)
    {
        $this->table = $table;

        event(new TableChanged($table->name, 'Added'));
    }
}
