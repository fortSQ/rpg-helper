<?php

namespace App\Helpers;

class MoneyDecorator
{
    /** Деньги в виде 1234 cp */
    const DISPLAY_AS_CP = 'cp';

    /** Деньги в виде 123 sp 4 cp */
    const DISPLAY_AS_SP_CP = 'sp_cp';

    /** Деньги в виде 12 gp 3 sp 4 cp */
    const DISPLAY_AS_GP_SP_CP = 'gp_sp_cp';

    protected $allowedDisplays = [
        self::DISPLAY_AS_CP,
        self::DISPLAY_AS_SP_CP,
        self::DISPLAY_AS_GP_SP_CP,
    ];

    const PRECISION_CP = 0;
    const PRECISION_SP = 1;
    const PRECISION_GP = 2;
    const PRECISION_PP = 3;

    protected $amount;

    /**
     * MoneyDecorator constructor.
     * @param int $amount Деньги в виде copper pieces (Cp)
     */
    public function __construct($amount) {
        $this->amount = $amount;
    }

    protected function roundAmount($amount, $precision) {
        $precision = max($precision, 0);
        if (!$precision) {
            return intval($amount);
        }
        $amount = round($amount, $precision + 1); // кол-во цифр после запятой
        $amount = explode('.', strval(floatval($amount)));
        if (isset($amount[1]) && strlen($amount[1]) > $precision) {
            $amount[1] = substr($amount[1], 0, $precision);
        }
        return abs(max(floatval(implode('.', $amount)), 0));
    }

    /**
     * CP-часть суммы
     * @example 4
     */
    public function getCp() {
        return $this->roundAmount($this->getTotalCp() - $this->getSP() * 10, self::PRECISION_CP);
    }

    /**
     * SP-часть суммы
     * @example 123
     */
    public function getSp() {
        return intval($this->roundAmount($this->getTotalCp(), self::PRECISION_CP) / 10);
    }

    /**
     * EP-часть суммы
     * @example 24
     */
    public function getEp() {
        return intval($this->roundAmount($this->getTotalCp(), self::PRECISION_CP) / 50);
    }

    /**
     * GP-часть суммы
     * @example 12
     */
    public function getGp() {
        return intval($this->roundAmount($this->getTotalCp(), self::PRECISION_CP) / 100);
    }

    /**
     * PP-часть суммы
     * @example 12
     */
    public function getPp() {
        return intval($this->roundAmount($this->getTotalCp(), self::PRECISION_CP) / 1000);
    }

    /**
     * Полная сумма в Cp
     * @example 1234
     */
    public function getTotalCp() {
        return $this->roundAmount($this->amount, self::PRECISION_CP);
    }

    /**
     * Полная сумма в Sp
     * @example 123.4
     */
    public function getTotalSp() {
        return $this->roundAmount($this->getTotalCp() / 10, self::PRECISION_SP);
    }

    /**
     * Полная сумма в Gp
     * @example 12.34
     */
    public function getTotalGp() {
        return $this->roundAmount($this->getTotalCp() / 100, self::PRECISION_GP);
    }

    /**
     * Полная сумма в Pp
     * @example 12.34
     */
    public function getTotalPp() {
        return $this->roundAmount($this->getTotalCp() / 1000, self::PRECISION_PP);
    }

    public function toSpCpString() {
        return $this->getSp() . ' sp ' . $this->getCp() . ' cp';
    }

    public function toGpSpCpString() {
        return

            ( $this->amount - ($this->amount / 100) ) . ' sp ' .
            ( $this->amount - ($this->amount / 10) ) . ' cp';
    }
}