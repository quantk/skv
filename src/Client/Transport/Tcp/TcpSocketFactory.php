<?php


namespace Skv\Client\Transport\Tcp;


use Amp\Promise;
use Amp\Socket\ConnectContext;
use Amp\Socket\EncryptableSocket;
use Skv\Client\Transport\SocketFactoryInterface;
use function Amp\call;
use function Amp\Socket\connect;

// @codeCoverageIgnoreStart
final class TcpSocketFactory implements SocketFactoryInterface
{
    /**
     * @param string $uri
     * @return \Amp\Promise
     */
    public function create(string $uri): Promise
    {
        return call(static function () use ($uri) {
            $connectContext = new ConnectContext();
            /** @var EncryptableSocket $socket */
            $socket = yield connect($uri, $connectContext);
            return $socket;
        });
    }
}
// @codeCoverageIgnoreEnd