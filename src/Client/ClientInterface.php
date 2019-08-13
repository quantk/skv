<?php
declare(strict_types=1);

namespace Skv\Client;


use Amp\Promise;

interface ClientInterface
{
    /**
     * @param string $key
     * @psalm-suppress MixedReturnTypeCoercion
     * @return Promise<string>
     */
    public function get(string $key): Promise;

    /**
     * @param string $key
     * @param mixed $value
     * @psalm-suppress MixedReturnTypeCoercion
     * @return Promise<void>
     */
    public function set(string $key, $value): Promise;
}