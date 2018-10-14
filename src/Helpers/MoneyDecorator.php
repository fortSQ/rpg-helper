<?php

namespace App\Helpers;

class MoneyDecorator
{
    /* Формат с Platinum Pieces */
    const FORMAT_PGSC = 'pp_gp_sp_cp';

    /* Формат с Gold Pieces */
    const FORMAT_GSC = 'gp_sp_cp';

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
     * getTotalIn() methods
     */

    /**
     * Полная сумма в Cp
     * @example 1234 => 1234
     */
    public function getTotalInCp(): int
    {
        return intval($this->amount);
    }

    /**
     * Полная сумма в Sp
     * @example 1234 => 123.4
     */
    public function getTotalInSp()
    {
        return round($this->amount / 10, self::PRECISION_SP);
    }

    /**
     * Полная сумма в Ep
     * @example 1234 => 24.68
     */
    public function getTotalInEp()
    {
        return round($this->amount / 50, self::PRECISION_EP);
    }

    /**
     * Полная сумма в Gp
     * @example 1234 => 12.34
     */
    public function getTotalInGp()
    {
        return round($this->amount / 100, self::PRECISION_GP);
    }

    /**
     * Полная сумма в Pp
     * @example 1234 => 1.234
     */
    public function getTotalInPp()
    {
        return round($this->amount / 1000, self::PRECISION_PP);
    }

    /******************************
     * getPart() methods
     */

    /**
     * CP-часть суммы
     * @example 1234 => 4
     */
    public function getCp()
    {
        return intval($this->getTotalInCp() - $this->getPp() * 1000 - $this->getGp() * 100 - $this->getSp() * 10);
    }

    /**
     * SP-часть суммы
     * @example 1234 => 3
     */
    public function getSp() {
        return intval(($this->getTotalInCp() - $this->getPp() * 1000 - $this->getGp() * 100) / 10);
    }

    /**
     * GP-часть суммы
     * @example 1234 => 2
     */
    public function getGp(): int {
        return intval( ($this->getTotalInCp() - $this->getPp() * 1000) / 100 );
    }

    /**
     * PP-часть суммы
     * @example 1234 => 1
     */
    public function getPp(): int
    {
        return intval($this->getTotalInCp() / 1000);
    }

    /**
     * GP-часть суммы для формата GSC
     * @example 1234 => 2
     */
    public function getGpForGp(): int {
        return intval( $this->getTotalInCp() / 100 );
    }

    /******************************
     * toString() methods
    */

    /**
     * Деньги в виде Pp Gp Sp Cp
     * @example 1234 => 1 pp 2 gp 3 sp 4 cp
     */
    public function toPpGpSpCpString(): string
    {
        return $this->getPp() . ' pp ' . $this->getGp() . ' gp ' . $this->getSp() . ' sp ' . $this->getCp() . ' cp';
    }

    /**
     * Деньги в виде Gp Sp Cp
     * @example 1234 => 12 gp 3 sp 4 cp
     */
    public function toGpSpCpString(): string
    {
        return $this->getGpForGp() . ' gp ' . $this->getSp() . ' sp ' . $this->getCp() . ' cp';
    }

}