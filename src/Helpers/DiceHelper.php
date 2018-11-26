<?php

namespace App\Helpers;

use App\Exception\DiceStringParseException;

class DiceHelper
{
    private $dice;

    public function __construct($diceString)
    {
        $this->dice = $this->parseDiceString($diceString);
    }

    public function roll()
    {
        $multiplier  = $this->dice['multiplier'] ? (int) $this->dice['multiplier'] : 1;
        $diceMaxSide = (int) $this->dice['max'];
        $operator    = $this->dice['operator'] ?? false;
        $modifier    = $this->dice['modifier'] ?? false;

        $result = 0;
        for ($i = 0; $i < $multiplier; $i++) {
            $result += random_int(1, $diceMaxSide);
        }

        switch ($operator) {
            case '+':
                $result += $modifier;
                break;
            case '-':
                $result -= $modifier;
                $result = $result < 0 ? 0 : $result;
                break;
        }

        return $result;
    }

    /**
     * @example xxxdxxxoxx, where x = [0-9], o = [+-]
     * @example '2d6+1' => [ 0 => "2d6+1", "multiplier" => "2", 1 => "2", "max" => "6", 2 => "6", "operator" => "+", 3 => "+", "modifier" => "1", 4 => "1" ]
     * @param string $diceString
     * @return false|int
     * @throws DiceStringParseException Строка с представлением кубов не соответствует требованиям
     */
    private function parseDiceString(string $diceString)
    {
        if (!preg_match('/^(?<multiplier>\d{0,3})d(?<max>\d{1,3})(?:(?<operator>[\+-])(?<modifier>\d{0,2}))?$/', $diceString, $matches)) {
            throw new DiceStringParseException('Dice string does not match requirements.');
        }

        return $matches;
    }
}
