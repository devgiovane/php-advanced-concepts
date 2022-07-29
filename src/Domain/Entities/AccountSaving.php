<?php


namespace Study\Domain\Entities;
/**
 * Class AccountSaving
 * @package Study\Domain\Entities
 */
final class AccountSaving extends Account
{
    /**
     * AccountCurrent constructor.
     * @param int|null $id
     * @param Holder $holder
     * @param float $balance
     */
    public function __construct(?int $id, Holder $holder, float $balance, string $type = "saving")
    {
        parent::__construct($id, $holder, $balance, $type);
    }

    /**
     * @return float
     */
    protected function tariffPercent(): float
    {
        return 0.03;
    }

}