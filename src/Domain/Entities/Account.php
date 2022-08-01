<?php


namespace Study\Domain\Entities;


use Study\Domain\Exceptions\InvalidValueException;
use Study\Domain\Exceptions\InsufficientFundsException;
use Study\Infrastructure\Repository\AccountSavingRepository;
use Study\Infrastructure\Repository\AccountCurrentRepository;
/**
 * Class Account
 * @package Study\Domain\Entities
 */
abstract class Account
{
    public const TYPES = [
        'saving' => AccountSavingRepository::class,
        'current' => AccountCurrentRepository::class
    ];
    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var Person
     */
    private $person;

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
     * @param Person $person
     * @param float $balance
     * @param string $type
     */
    public function __construct(?int $id, Person $person, float $balance, string $type)
    {
        $this->id = $id;
        $this->person = $person;
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
     * @return Person
     */
    public function getPerson(): Person
    {
        return $this->person;
    }

    /**
     * @param Person $person
     */
    public function setPerson(Person $person): void
    {
        $this->person = $person;
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