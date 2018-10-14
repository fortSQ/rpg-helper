<?php

namespace App\Helpers;

class MoneyDecorator
{
    const FORMAT_START_PP = 'pp_gp_sp_cp';
    const FORMAT_START_GP = 'gp_sp_cp';

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

    /******************************
     * getTotal() methods
     */

    /**
     * Полная сумма в Cp
     * @example 1234 => 1234
     */
    public function getTotalCp(): int
    {
        return intval($this->amount);
    }

    /**
     * Полная сумма в Sp
     * @example 1234 => 123.4
     */
    public function getTotalSp()
    {
        return round($this->amount / 10, self::PRECISION_SP);
    }

    /**
     * Полная сумма в Ep
     * @example 1234 => 24.68
     */
    public function getTotalEp()
    {
        return round($this->amount / 50, self::PRECISION_EP);
    }

    /**
     * Полная сумма в Gp
     * @example 1234 => 12.34
     */
    public function getTotalGp()
    {
        return round($this->amount / 100, self::PRECISION_GP);
    }

    /**
     * Полная сумма в Pp
     * @example 1234 => 1.234
     */
    public function getTotalPp()
    {
        return round($this->amount / 1000, self::PRECISION_PP);
    }

    /******************************
     * toPpGpSpCpString() methods
    */

    /**
     * @return string
     * @throws \Exception
     */
    public function toPpGpSpCpString(): string
    {
        return $this->getPp() . ' pp ' . $this->getGp() . ' gp ' . $this->getSp() . ' sp ' . $this->getCp() . ' cp';
    }

    /**
     * CP-часть суммы
     * @example 1234 => 4
     */
    public function getCp()
    {
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

    /******************************
     * toGpSpCpString() methods
     */

    public function toGpSpCpString(): string
    {
        return $this->getGpForGp() . ' gp ' . $this->getSp() . ' sp ' . $this->getCp() . ' cp';
    }

    /**
     * GP-часть суммы
     * @example 1234 => 2
     */
    public function getGpForGp(): int {
        return intval( $this->getTotalCp() / 100 );
    }





    /**
     * EP-часть суммы
     * @example 24
     */
    public function getEp()
    {
        //return intval($this->roundAmount($this->getTotalCp(), self::PRECISION_CP) / 50);
    }

}