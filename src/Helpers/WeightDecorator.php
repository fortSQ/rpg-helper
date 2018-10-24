<?php

namespace App\Helpers;

class WeightDecorator
{
    const TYPE_G    = 'g';
    const TYPE_KG   = 'kg';

    const TYPE_OZ   = 'oz'; //ounces
    const TYPE_LB   = 'lb'; //pounds

    const WEIGHT_IN_GRAMS = [
        self::TYPE_KG   => 1000,
        self::TYPE_G    => 1,
    ];

    const TYPE_TO_STRING = [
        self::TYPE_KG   => 'kg',
        self::TYPE_G    => 'g',
    ];

    private $weight = 0.0;

    public function __construct($weightInLb)
    {
        $this->weight = $weightInLb;
    }

    public function __toString()
    {
        return $this->toKgGString();
    }

    /**
     * @example 123 = 123 lb
     */
    public function toLbString()
    {
        return $this->weight . ' lb.';
    }

    /**
     * @example 123 lb = 55 kg 791 g
     */
    public function toKgGString()
    {
        $string = '';
        $weight = $this->toGrams();

        foreach (self::WEIGHT_IN_GRAMS as $type => $ratio) {
            list($count, $weight) = $this->test($weight, $ratio);
            if ($count) {
                $string .= ' ' . $count . ' ' . self::TYPE_TO_STRING[$type];
            }
        }

        return ltrim($string);
    }

    /**
     * @example 123 => 55791.86151
     */
    private function toGrams()
    {
        return $this->weight * 453.59237;
    }

    private function test($weight, $ratio)
    {
        $count = floor($weight / $ratio);

        return [$count, $weight - $count * $ratio];
    }
}
