<?php

namespace App\Helpers;

use App\Exception\DiceStringParseException;

class DiceHelper
{
    public function roll(string $diceString)
    {
        $data = $this->parseDiceString($diceString);

        $multiplier = $data['multiplier'] ? (int) $data['multiplier'] : 1;
        $max        = (int) $data['max'];
        $operator   = $data['operator'] ?? false;
        $modifier   = $data['modifier'] ?? false;

        $result = 0;
        for ($i = 0; $i < $multiplier; $i++) {
            $result += random_int(1, $max);
        }

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

    /**
     * @example xxdxxxox, where x = [0-9], 0 = [+-]
     * @example '2d6+1' => [ 0 => "2d6+1", "multiplier" => "2", 1 => "2", "max" => "6", 2 => "6", "operator" => "+", 3 => "+", "modifier" => "1", 4 => "1" ]
     * @param string $diceString
     * @return false|int
     * @throws DiceStringParseException Строка с представлением кубов не соответствует требованиям
     */
    public function parseDiceString(string $diceString)
    {
        if (!preg_match('/(?<multiplier>\d{0,2})d(?<max>\d{1,3})(?:(?<operator>[\+-])(?<modifier>\d?))?/', $diceString, $matches)) {
            throw new DiceStringParseException('Dice string does not match requirements');
        }

        return $matches;
    }
}
