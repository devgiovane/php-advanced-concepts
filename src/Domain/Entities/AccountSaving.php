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
     * @param Person $person
     * @param float $balance
     * @param string $type
     */
    public function __construct(?int $id, Person $person, float $balance, string $type = "saving")
    {
        parent::__construct($id, $person, $balance, $type);
    }

    /**
     * @return float
     */
    protected function tariffPercent(): float
    {
        return 0.03;
    }

}