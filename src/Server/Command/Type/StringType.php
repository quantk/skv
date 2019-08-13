<?php
declare(strict_types=1);

namespace Skv\Server\Command\Type;


class StringType implements TypeInterface
{
    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'string';
    }

    /**
     * @param mixed $data
     * @return string
     */
    public function serialize($data): string
    {
        return '+' . (string)$data;
    }

    /**
     * @param string $data
     * @return mixed
     */
    public function unserialize(string $data)
    {
        return substr($data, 1);
    }
}