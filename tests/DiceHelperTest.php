<?php

namespace App\Tests\Helpers;

use App\Helpers\DiceHelper;
use PHPUnit\Framework\TestCase;

class DiceHelperTest extends TestCase
{
    const TIMES = 1000;

    public function testDiceD6()
    {
        $dice = new DiceHelper('d6');
        $this->repeat($dice, self::TIMES, 1, 6);
    }

    public function testDice1D6plus1()
    {
        $dice = new DiceHelper('1d6+1');
        $this->repeat($dice, self::TIMES, 2, 7);
    }

    public function testDice2D20minus1()
    {
        $dice = new DiceHelper('2d20-1');
        $this->repeat($dice, self::TIMES, 1, 39);
    }

    private function repeat($dice, $times, $min, $max)
    {
        for ($i = 0; $i < $times; $i++) {
            /** @var DiceHelper $dice */
            $result = $dice->roll();
            $this->assertTrue(($min <= $result) && ($result <= $max));
        }
    }
}
