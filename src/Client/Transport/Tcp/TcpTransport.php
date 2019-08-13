<?php
declare(strict_types=1);

namespace Skv\Client\Transport\Tcp;


use Amp\Promise;
use Amp\Socket\EncryptableSocket;
use Skv\Client\Transport\SocketFactoryInterface;
use Skv\Client\Transport\TransportInterface;
use function Amp\call;

class TcpTransport implements TransportInterface
{
    /**
     * @var string
     */
    private $uri;
    /**
     * @var SocketFactoryInterface
     */
    private $socketFactory;

    /**
     * HttpTransport constructor.
     * @param string $uri
     * @param SocketFactoryInterface $tcpSocketFactory
     */
    public function __construct(
        string $uri,
        SocketFactoryInterface $tcpSocketFactory = null
    )
    {
        if ($tcpSocketFactory === null) {
            $tcpSocketFactory = new TcpSocketFactory();
        }
        $this->socketFactory = $tcpSocketFactory;
        $this->uri           = $uri;
    }

    /**
     * @return SocketFactoryInterface
     */
    public function getSocketFactory(): SocketFactoryInterface
    {
        return $this->socketFactory;
    }

    /**
     * @param string $command
     * @param string $args
     * @psalm-suppress MixedReturnTypeCoercion
     * @return Promise<string>
     */
    public function request(string $command, string $args): Promise
    {
        return call(function () use ($command, $args) {
            /** @var EncryptableSocket $socket */
            $socket = yield $this->connect();

            yield $socket->write($command . ' ' . $args);

            /** @var string $response */
            $response = '';
            while ($chunk = yield $socket->read()) {
                /** @psalm-suppress InvalidOperand */
                $response .= $chunk;
            }

            return $response;
        });
    }

    /**
     * @psalm-suppress MixedReturnTypeCoercion
     * @return Promise<EncryptableSocket>
     */
    public function connect(): Promise
    {
        return call(function () {
            return $this->socketFactory->create($this->uri);
        });
    }
}