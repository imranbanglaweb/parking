<?php

namespace App\Voyager\Database\Types\Postgresql;

use App\Voyager\Database\Types\Common\CharType;

class CharacterType extends CharType
{
    const NAME = 'character';
    const DBTYPE = 'bpchar';
}
