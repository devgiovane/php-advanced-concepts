<?php


namespace Study\Domain\Entity;


use http\Exception\InvalidArgumentException;
/**
 * Class Account
 * @package Study\Domain\Entity
 */
abstract class Account
{
    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var Holder
     */
    private $holder;

    /**
     * @var float
     */
    private $balance;

    /**
     * Account constructor.
     * @param int|null $id
     * @param Holder $holder
     * @param float $balance
     */
    public function __construct(?int $id, Holder $holder, float $balance)
    {
        $this->id = $id;
        $this->holder = $holder;
        $this->balance = $balance;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Holder
     */
    public function getHolder(): Holder
    {
        return $this->holder;
    }

    /**
     * @param Holder $holder
     */
    public function setHolder(Holder $holder): void
    {
        $this->holder = $holder;
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @param float $balance
     */
    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
    }

    /**
     * @param float $value
     */
    public function cashDeposit(float $value): void
    {
        if($value < 0) {
            throw new InvalidArgumentException();
        }
        $this->balance += $value;
    }

    /**
     * @param float $value
     * @throws InsufficientFundsException
     */
    public function cashRemove(float $value): void
    {
        $tariff = $value * $this->tariffPercent();
        $newValue = $value + $tariff;
        if($newValue > $this->getBalance()) {
            throw new InsufficientFundsException($newValue, $this->getBalance());
        }
        $this->setBalance($this->getBalance() - $newValue);
    }

    /**
     * @return float
     */
    protected abstract function tariffPercent(): float;

}