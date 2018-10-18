<?php

namespace App\Helpers;

class MoneyDecorator
{
    const TYPE_PLATINUM = 'pp';
    const TYPE_GOLD     = 'gp';
    const TYPE_SILVER   = 'sp';
    const TYPE_COPPER   = 'cp';

    const RATION_IN_COPPER = [
        self::TYPE_PLATINUM => 1000,
        self::TYPE_GOLD     => 100,
        self::TYPE_SILVER   => 10,
        self::TYPE_COPPER   => 1,
    ];

    private $amount = 0;

    public function __construct($amountInCopper)
    {
        $this->amount = $amountInCopper;
    }

    public function test($amount, $type)
    {
        $ratio = self::RATION_IN_COPPER[$type];
        $count = floor($amount / $ratio);

        return [$count, $amount - $count * $ratio];
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

            list($count, $amount) = $this->test($amount, $type);
            if ($count or $showEmptyValues) {
                $string .= ' ' . $count . $type;
            }
        }

        return ltrim($string);
    }
}
