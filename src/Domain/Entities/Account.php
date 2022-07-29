<?php


namespace Study\Domain\Entities;


use Study\Domain\Exceptions\InvalidValueException;
use Study\Domain\Exceptions\InsufficientFundsException;
/**
 * Class Account
 * @package Study\Domain\Entities
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
     * @var string
     */
    private $type;

    /**
     * Account constructor.
     * @param int|null $id
     * @param Holder $holder
     * @param float $balance
     * @param string $type
     */
    public function __construct(?int $id, Holder $holder, float $balance, string $type)
    {
        $this->id = $id;
        $this->holder = $holder;
        $this->balance = $balance;
        $this->type = $type;
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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @param float $value
     */
    public function cashDeposit(float $value): void
    {
        if($value < 0) {
            throw new InvalidValueException();
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