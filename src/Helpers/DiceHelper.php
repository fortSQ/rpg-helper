<?php

namespace App\Helpers;

class DiceHelper
{
    public function roll(string $diceString)
    {
        $data = $this->parseDiceString($diceString);

        $multiplier = $data['multiplier'] ? (int) $data['multiplier']: 1;
        $max        = (int) $data['max'];
        $operator   = $data['operator'] ?? false;
        $modifier   = $data['modifier'] ?? false;

        $result = $multiplier * $this->rollSingleD($max);



        switch ($operator) {
            case '+':
                $result = $result + $modifier;
                break;
            case '-':
                $result = $result - $modifier;
                $result = $result < 0 ? 0 : $result;
                break;
        }

        return $result;
    }

    public function rollSingleD($max)
    {
        return random_int(1, $max);
    }

    /**
     * @example '2d6+1' => [ 0 => "2d6+1", "multiplier" => "2", 1 => "2", "max" => "6", 2 => "6", "operator" => "+", 3 => "+", "modifier" => "1", 4 => "1" ]
     * @param string $diceString
     * @return false|int
     */
    public function parseDiceString(string $diceString)
    {
        preg_match('/(?<multiplier>\d{0,2})d(?<max>\d{1,3})(?:(?<operator>[\+-])(?<modifier>\d?))?/', $diceString, $matches);

        return $matches;
    }



}