<?php


namespace Study\Domain\Entities;


use Study\Domain\Exceptions\InsufficientFundsException;
/**
 * Class AccountCurrent
 * @package Study\Domain\Entities
 */
final class AccountCurrent extends Account
{
    /**
     * AccountCurrent constructor.
     * @param int|null $id
     * @param Person $person
     * @param float $balance
     * @param string $type
     */
    public function __construct(?int $id, Person $person, float $balance, string $type = "current")
    {
        parent::__construct($id, $person, $balance, $type);
    }

    /**
     * @param float $value
     * @param Account $account
     */
    public function transfer(float $value, Account $account): void
    {
        if($value > $this->getBalance()) {
            throw new InsufficientFundsException($value, $this->getBalance());
        }
        $this->cashRemove($value);
        $account->cashDeposit($value);
    }

    /**
     * @return float
     */
    protected function tariffPercent(): float
    {
        return 0.05;
    }

}