<?php


namespace Tests\Client\Transport;


use Amp\PHPUnit\AsyncTestCase;
use Amp\Socket\EncryptableSocket;
use Amp\Success;
use PHPUnit\Framework\MockObject\MockObject;
use Skv\Client\Transport\SocketFactoryInterface;
use Skv\Client\Transport\Tcp\TcpSocketFactory;
use Skv\Client\Transport\Tcp\TcpTransport;

class TcpTransportTest extends AsyncTestCase
{
    public function testCreateWithDefaultSocketFactory()
    {
        $tcpTransport = new TcpTransport('tcp://127.0.0.1');
        static::assertInstanceOf(TcpSocketFactory::class, $tcpTransport->getSocketFactory());

    }

    public function testConnect()
    {
        /** @var MockObject|SocketFactoryInterface $socketFactory */
        $socketFactory = $this->createMock(SocketFactoryInterface::class);
        $tcpTransport  = new TcpTransport('tcp://127.0.0.1', $socketFactory);
        $socket        = $this->createMock(EncryptableSocket::class);
        $socketFactory->method('create')->willReturn(new Success($socket));
        $resultSocket = yield $tcpTransport->connect();
        static::assertSame($socket, $resultSocket);
    }

    public function testRequest()
    {
        /** @var MockObject|SocketFactoryInterface $socketFactory */
        $socketFactory = $this->createMock(SocketFactoryInterface::class);
        $tcpTransport  = new TcpTransport('tcp://127.0.0.1', $socketFactory);
        $socket        = $this->createMock(EncryptableSocket::class);
        $socketFactory->method('create')->willReturn(new Success($socket));

        $socket->method('write')->with('GET key')->willReturn(new Success());
        $socket->method('read')->willReturnOnConsecutiveCalls(new Success("SUCCESS\r\n+value"), new Success(null));

        $result = yield $tcpTransport->request('GET', 'key');
        static::assertSame("SUCCESS\r\n+value", $result);
    }
}