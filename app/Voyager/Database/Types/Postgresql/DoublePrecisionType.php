<?php

namespace App\Voyager\Database\Types\Postgresql;

use App\Voyager\Database\Types\Common\DoubleType;

class DoublePrecisionType extends DoubleType
{
    const NAME = 'double precision';
    const DBTYPE = 'float8';
}
