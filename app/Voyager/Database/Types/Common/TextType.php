<?php

namespace App\Voyager\Database\Types\Common;

use App\Voyager\Database\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class TextType extends Type
{
    const NAME = 'text';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'text';
    }
}
