<?php

namespace App\Tests\Helpers;

use App\Helpers\MoneyDecorator;
use PHPUnit\Framework\TestCase;

class MoneyDecoratorTest extends TestCase
{
    public function testMoney1()
    {
        $money = new MoneyDecorator(1234);

        $this->assertEquals('12 gp 3 sp 4 cp', $money->__toString());
        $this->assertEquals('12 gp 3 sp 4 cp', $money->toString());

        $this->assertEquals('12 gp 3 sp 4 cp', $money->toString(false));
        $this->assertEquals('1 pp 2 gp 3 sp 4 cp', $money->toString(false, MoneyDecorator::TYPE_PLATINUM));
        $this->assertEquals('12 gp 3 sp 4 cp', $money->toString(false, MoneyDecorator::TYPE_GOLD));
        $this->assertEquals('123 sp 4 cp', $money->toString(false, MoneyDecorator::TYPE_SILVER));
        $this->assertEquals('1234 cp', $money->toString(false, MoneyDecorator::TYPE_COPPER));
    }

    public function testMoney2()
    {
        $money = new MoneyDecorator(5060);

        $this->assertEquals('50 gp 6 sp', $money->__toString());
        $this->assertEquals('50 gp 6 sp', $money->toString());

        $this->assertEquals('50 gp 6 sp', $money->toString(false));
        $this->assertEquals('5 pp 6 sp', $money->toString(false, MoneyDecorator::TYPE_PLATINUM));
        $this->assertEquals('50 gp 6 sp', $money->toString(false, MoneyDecorator::TYPE_GOLD));
        $this->assertEquals('506 sp', $money->toString(false, MoneyDecorator::TYPE_SILVER));
        $this->assertEquals('5060 cp', $money->toString(false, MoneyDecorator::TYPE_COPPER));

        $this->assertEquals('50 gp 6 sp 0 cp', $money->toString(true));
        $this->assertEquals('5 pp 0 gp 6 sp 0 cp', $money->toString(true, MoneyDecorator::TYPE_PLATINUM));
        $this->assertEquals('50 gp 6 sp 0 cp', $money->toString(true, MoneyDecorator::TYPE_GOLD));
        $this->assertEquals('506 sp 0 cp', $money->toString(true, MoneyDecorator::TYPE_SILVER));
        $this->assertEquals('5060 cp', $money->toString(true, MoneyDecorator::TYPE_COPPER));
    }
}
