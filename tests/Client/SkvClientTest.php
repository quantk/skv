<?php


namespace Tests\Client;


use Amp\PHPUnit\AsyncTestCase;
use Amp\Success;
use PHPUnit\Framework\MockObject\MockObject;
use Skv\Client\SkvClient;
use Skv\Client\Transport\TransportInterface;

class SkvClientTest extends AsyncTestCase
{
    public function testSet()
    {
        /** @var MockObject|TransportInterface $transport */
        $transport = $this->createMock(TransportInterface::class);
        $transport->expects(static::once())->method('request')->willReturn(new Success("SUCCESS\r\n"));
        $client = new SkvClient($transport);

        yield $client->set('key', 'value');
    }

    public function testSetWithErrors()
    {
        /** @var MockObject|TransportInterface $transport */
        $transport = $this->createMock(TransportInterface::class);
        $testError = 'TestError';
        $transport->expects(static::once())->method('request')->willReturn(new Success("ERROR\r\n{$testError}"));
        $client = new SkvClient($transport);
        $this->expectException(\RuntimeException::class);
        yield $client->set('key', 'value');
    }

    public function testGet()
    {
        /** @var MockObject|TransportInterface $transport */
        $transport = $this->createMock(TransportInterface::class);
        $transport->expects(static::once())->method('request')->willReturn(new Success("SUCCESS\r\n+Value"));
        $client = new SkvClient($transport);
        $result = yield $client->get('key');
        static::assertSame($result, 'Value');
    }

    public function testGetWithErrors()
    {
        /** @var MockObject|TransportInterface $transport */
        $transport = $this->createMock(TransportInterface::class);
        $testError = 'TestError';
        $transport->expects(static::once())->method('request')->willReturn(new Success("ERROR\r\n{$testError}"));
        $client = new SkvClient($transport);
        $this->expectException(\RuntimeException::class);
        yield $client->get('key');
    }
}