<?php


namespace Skv\Client\Transport;


use Amp\Promise;

interface SocketFactoryInterface
{
    /**
     * @param string $uri
     * @return \Amp\Promise
     */
    public function create(string $uri): Promise;
}