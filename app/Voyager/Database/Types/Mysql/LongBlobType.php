<?php

namespace App\Voyager\Database\Types\Mysql;

use App\Voyager\Database\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class LongBlobType extends Type
{
    const NAME = 'longblob';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'longblob';
    }
}
