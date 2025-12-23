<?php

namespace App\Voyager\Database\Types\Mysql;

use App\Voyager\Database\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class TimeStampType extends Type
{
    const NAME = 'timestamp';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        if (isset($field['default'])) {
            return 'timestamp';
        }

        return 'timestamp null';
    }
}
