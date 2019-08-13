<?php


namespace Tests\Server\Command\Type;


use PHPUnit\Framework\TestCase;
use Skv\Server\Command\Type\StringType;

class StringTypeTest extends TestCase
{
    public function testGetName()
    {
        static::assertSame(StringType::getName(), 'string');
    }

    public function testSerialize()
    {
        $type = new StringType();
        static::assertSame($type->serialize('data'), '+data');
    }

    public function testUnserialize()
    {
        $type = new StringType();
        static::assertSame($type->unserialize('+data'), 'data');
    }
}