<?php

namespace App\Voyager\Database\Types\Mysql;

use App\Voyager\Database\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class PointType extends Type
{
    const NAME = 'point';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'point';
    }
}
