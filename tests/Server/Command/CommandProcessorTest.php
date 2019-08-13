<?php


namespace Tests\Server\Command;


use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Skv\Server\Command\CommandProcessor;
use Skv\Server\Store\Store;

class CommandProcessorTest extends TestCase
{
    public function testProcess()
    {
        $store = new Store();

        $commandProcessor = new CommandProcessor($store);
        $rawData          = 'SET key,+value';
        $result           = $commandProcessor->process($rawData);
        static::assertTrue($result->isSuccessful());

        $rawData = 'GET key';
        $result  = $commandProcessor->process($rawData);
        static::assertTrue($result->isSuccessful());
        static::assertSame($result->payload, '+value');
    }

    public function testProcessWithErrors()
    {
        /** @var MockObject|Store $store */
        $store = $this->createMock(Store::class);
        $error = 'test error';
        $store->method('set')->willThrowException(new \RuntimeException($error));

        $commandProcessor = new CommandProcessor($store);
        $rawData          = 'SET key,+value';
        $result           = $commandProcessor->process($rawData);
        static::assertFalse($result->isSuccessful());
        static::assertSame(count($result->errors), 1);
    }
}