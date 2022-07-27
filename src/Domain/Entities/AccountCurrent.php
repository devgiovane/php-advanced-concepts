<?php


namespace Study\Domain\Entities;


use Study\Domain\Exceptions\InsufficientFundsException;
/**
 * Class AccountCurrent
 * @package Study\Domain\Entities
 */
final class AccountCurrent extends Account implements Serializable
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

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array(
            'id' => $this->getId(),
            'holder' => $this->getHolder()->toArray(),
            'balance' => $this->getBalance(),
            'type' => 'current'
        );
    }
}