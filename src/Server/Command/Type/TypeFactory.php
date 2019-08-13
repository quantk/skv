<?php
declare(strict_types=1);

namespace Skv\Server\Command\Type;


class TypeFactory
{
    /**
     * @param mixed $data
     * @return StringType
     */
    public static function create($data)
    {
        return new StringType();
    }
}