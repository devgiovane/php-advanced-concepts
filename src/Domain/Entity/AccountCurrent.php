<?php


namespace Study\Domain\Entity;
/**
 * Class AccountCurrent
 * @package Study\Domain\Entity
 */
final class AccountCurrent extends Account
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