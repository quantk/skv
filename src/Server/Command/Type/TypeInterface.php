<?php
declare(strict_types=1);

namespace Skv\Server\Command\Type;


interface TypeInterface
{
    /**
     * @return string
     */
    public static function getName(): string;

    /**
     * @param mixed $data
     * @return string
     */
    public function serialize($data): string;

    /**
     * @param string $data
     * @return mixed
     */
    public function unserialize(string $data);
}