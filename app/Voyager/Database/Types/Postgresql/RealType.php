<?php

namespace App\Voyager\Database\Types\Postgresql;

use App\Voyager\Database\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class RealType extends Type
{
    const NAME = 'real';
    const DBTYPE = 'float4';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'real';
    }
}
