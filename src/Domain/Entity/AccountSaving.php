<?php


namespace Study\Domain\Entity;
/**
 * Class AccountSaving
 * @package Study\Domain\Entity
 */
final class AccountSaving extends Account
{
    /**
     * AccountCurrent constructor.
     * @param int|null $id
     * @param Holder $holder
     * @param float $balance
     */
    public function __construct(?int $id, Holder $holder, float $balance)
    {
        parent::__construct($id, $holder, $balance);
    }

    /**
     * @return float
     */
    protected function tariffPercent(): float
    {
        return 0.03;
    }

}