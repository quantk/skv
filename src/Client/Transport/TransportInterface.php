<?php
declare(strict_types=1);

namespace Skv\Client\Transport;


use Amp\Promise;

interface TransportInterface
{
    /**
     * @param string $command
     * @param string $args
     * @psalm-suppress MixedReturnTypeCoercion
     * @return Promise<string>
     */
    public function request(string $command, string $args): Promise;
}