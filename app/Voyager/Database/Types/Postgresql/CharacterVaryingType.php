<?php

namespace App\Voyager\Database\Types\Postgresql;

use App\Voyager\Database\Types\Common\VarCharType;

class CharacterVaryingType extends VarCharType
{
    const NAME = 'character varying';
    const DBTYPE = 'varchar';
}
