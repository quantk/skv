<?php
declare(strict_types=1);

namespace Skv\Server\Command\Type;


class NullType implements TypeInterface
{
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'null';
    }

    /**
     * @param mixed $data
     * @return string
     */
    public function serialize($data): string
    {
        return 'NULL';
    }

    /**
     * @param string $data
     * @return mixed
     */
    public function unserialize(string $data)
    {
        return null;
    }
}