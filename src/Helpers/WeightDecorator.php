<?php

namespace App\Helpers;

class WeightDecorator
{
    const SYSTEM_G      = 'g';
    const SYSTEM_KG     = 'kg';
    const SYSTEM_KG_G   = 'kg_g';

    const SYSTEM_OZ     = 'oz';
    const SYSTEM_LB     = 'lb';
    const SYSTEM_LB_OZ  = 'lb_oz';




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




    private $weight = 0;

    public function __construct($weightInLb)
    {
        $this->weight = $weightInLb;
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function toKgString()
    {
        return $this->weight / 2.2046;
    }






    public function test($amount, $type)
    {
        $ratio = self::RATION_IN_COPPER[$type];
        $count = floor($amount / $ratio);

        return [$count, $amount - $count * $ratio];
    }

    public function toString()
    {
        $string = '';

        return $string;
    }


}
