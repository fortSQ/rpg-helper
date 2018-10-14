<?php

namespace App\Tests\Helpers;

use App\Helpers\MoneyDecorator;
use PHPUnit\Framework\TestCase;

class MoneyDecoratorTest extends TestCase
{
    public function testMoney1()
    {
        $money = new MoneyDecorator(1234);

        $this->assertEquals(1234, $money->getTotalInCp());
        $this->assertEquals(123.4, $money->getTotalInSp());
        $this->assertEquals(24.68, $money->getTotalInEp());
        $this->assertEquals(12.34, $money->getTotalInGp());
        $this->assertEquals(1.234, $money->getTotalInPp());

        $this->assertEquals(4, $money->getCp());
        $this->assertEquals(3, $money->getSp());
        $this->assertEquals(2, $money->getGp());
        $this->assertEquals(12, $money->getGpForGp());
        $this->assertEquals(1, $money->getPp());

        $this->assertEquals('1 pp 2 gp 3 sp 4 cp', $money->toPpGpSpCpString());
        $this->assertEquals('12 gp 3 sp 4 cp', $money->toGpSpCpString());
    }

    public function testMoney2()
    {
        $money = new MoneyDecorator(5678);

        $this->assertEquals(5678, $money->getTotalInCp());
        $this->assertEquals(567.8, $money->getTotalInSp());
        $this->assertEquals(113.56, $money->getTotalInEp());
        $this->assertEquals(56.78, $money->getTotalInGp());
        $this->assertEquals(5.678, $money->getTotalInPp());

        $this->assertEquals(8, $money->getCp());
        $this->assertEquals(7, $money->getSp());
        $this->assertEquals(6, $money->getGp());
        $this->assertEquals(56, $money->getGpForGp());
        $this->assertEquals(5, $money->getPp());

        $this->assertEquals('5 pp 6 gp 7 sp 8 cp', $money->toPpGpSpCpString());
        $this->assertEquals('56 gp 7 sp 8 cp', $money->toGpSpCpString());
    }
}
