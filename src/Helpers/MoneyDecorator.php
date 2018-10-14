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
    const PRECISION_EP = 2;
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







    /**
     * CP-часть суммы
     * @example 4
     */
    public function getCp() {
        return intval($this->getTotalCp() - $this->getPp() * 1000 - $this->getGp() * 100 - $this->getSp() * 10);
    }

    /**
     * SP-часть суммы
     * @example 1234 => 3
     */
    public function getSp() {
        return intval(($this->getTotalCp() - $this->getPp() * 1000 - $this->getGp() * 100) / 10);
    }

    /**
     * GP-часть суммы
     * @example 1234 => 2
     */
    public function getGp(): int {
        return intval( ($this->getTotalCp() - $this->getPp() * 1000) / 100 );
    }

    /**
     * PP-часть суммы
     * @example 1234 => 1
     */
    public function getPp(): int
    {
        return intval($this->getTotalCp() / 1000);
    }

    /**
     * Полная сумма в Cp
     * @example 1234 => 1234
     */
    public function getTotalCp(): int {
        return intval($this->amount);
    }

    /**
     * Полная сумма в Sp
     * @example 1234 => 123.4
     */
    public function getTotalSp() {
        return round($this->amount / 10, self::PRECISION_SP);
    }

    /**
     * Полная сумма в Ep
     * @example 1234 => 24.68
     */
    public function getTotalEp() {
        return round($this->amount / 50, self::PRECISION_EP);
    }

    /**
     * Полная сумма в Gp
     * @example 1234 => 12.34
     */
    public function getTotalGp() {
        return round($this->amount / 100, self::PRECISION_GP);
    }

    /**
     * Полная сумма в Pp
     * @example 1234 => 1.234
     */
    public function getTotalPp() {
        return round($this->amount / 1000, self::PRECISION_PP);
    }

    public function toPpGpSpCpString(): string
    {
        return $this->getPp() . ' pp ' . $this->getGp() . ' gp ' . $this->getSp() . ' sp ' . $this->getCp() . ' cp';
    }





    /**
     * EP-часть суммы
     * @example 24
     */
    public function getEp() {
        //return intval($this->roundAmount($this->getTotalCp(), self::PRECISION_CP) / 50);
    }

}