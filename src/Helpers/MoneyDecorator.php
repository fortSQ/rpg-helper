<?php

namespace App\Helpers;

class MoneyDecorator
{
    const TYPE_PLATINUM = 'P';
    const TYPE_GOLD     = 'G';
    const TYPE_SILVER   = 'S';
    const TYPE_COPPER   = 'C';

    const RATION_IN_COPPER = [
        self::TYPE_PLATINUM => 1000,
        self::TYPE_GOLD     => 100,
        self::TYPE_SILVER   => 10,
        self::TYPE_COPPER   => 1,
    ];

    const TYPE_TO_STRING = [
        self::TYPE_PLATINUM => 'pp',
        self::TYPE_GOLD     => 'gp',
        self::TYPE_SILVER   => 'sp',
        self::TYPE_COPPER   => 'cp',
    ];

    private $amount = 0;

    public function __construct($amountInCopper)
    {
        $this->amount = $amountInCopper;
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function toString($showEmptyValues = false, $startType = self::TYPE_GOLD)
    {
        $string = '';
        $showType = false;
        $amount = $this->amount;

        foreach (self::RATION_IN_COPPER as $type => $ratio) {
            if ($startType == $type) {
                $showType = true;
            }
            if (!$showType) {
                continue;
            }

            list($count, $amount) = $this->test($amount, $ratio);
            if ($count or $showEmptyValues) {
                $string .= ' ' . $count . ' ' . self::TYPE_TO_STRING[$type];
            }
        }

        return ltrim($string);
    }

    private function test($amount, $ratio)
    {
        $count = floor($amount / $ratio);

        return [$count, $amount - $count * $ratio];
    }
}
