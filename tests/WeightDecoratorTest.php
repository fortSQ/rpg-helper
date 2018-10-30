<?php

namespace App\Tests\Helpers;

use App\Helpers\WeightDecorator;
use PHPUnit\Framework\TestCase;

class WeightDecoratorTest extends TestCase
{
    public function testWeight1()
    {
        $weight = new WeightDecorator(123);

        $this->assertEquals('55 kg 791 g', $weight->__toString());
        $this->assertEquals('55 kg 791 g', $weight->toKgGString());
        $this->assertEquals('123 lb.', $weight->toLbString());
    }
}
