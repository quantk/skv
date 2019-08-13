<?php


namespace Tests\Server\Command\Type;


use PHPUnit\Framework\TestCase;
use Skv\Server\Command\Type\NullType;

class NullTypeTest extends TestCase
{
    public function testGetName()
    {
        static::assertSame(NullType::getName(), 'null');
    }

    public function testSerialize()
    {
        $type = new NullType();
        static::assertSame($type->serialize('data'), 'NULL');
    }

    public function testUnserialize()
    {
        $type = new NullType();
        static::assertNull($type->unserialize('data'));
    }
}