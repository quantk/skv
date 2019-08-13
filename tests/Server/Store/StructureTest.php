<?php


namespace Tests\Server\Store;


use PHPUnit\Framework\TestCase;
use Skv\Server\Command\Type\StringType;
use Skv\Server\Store\Structure;

class StructureTest extends TestCase
{
    public function testEvaluate()
    {
        $structure = new Structure('key', 'value', new StringType());
        static::assertSame($structure->evaluate(), '+value');
    }
}