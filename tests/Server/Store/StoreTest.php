<?php


namespace Tests\Server\Store;


use PHPUnit\Framework\TestCase;
use Skv\Server\Command\Type\StringType;
use Skv\Server\Store\Store;

class StoreTest extends TestCase
{
    public function testSetAndGet()
    {
        $store = new Store();
        $key   = 'key';
        $value = '+value';
        $store->set($key, $value);

        $savedValue = $store->get($key);
        static::assertSame($savedValue->value, substr($value, 1));
        static::assertInstanceOf(StringType::class, $savedValue->type);
        static::assertSame($savedValue->key, $key);
    }
}