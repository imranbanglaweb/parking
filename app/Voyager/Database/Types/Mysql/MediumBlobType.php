<?php

namespace App\Voyager\Database\Types\Mysql;

use App\Voyager\Database\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class MediumBlobType extends Type
{
    const NAME = 'mediumblob';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'mediumblob';
    }
}
