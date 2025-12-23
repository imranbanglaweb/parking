<?php

namespace App\Voyager\Database\Types\Sqlite;

use App\Voyager\Database\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class RealType extends Type
{
    const NAME = 'real';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'real';
    }
}
