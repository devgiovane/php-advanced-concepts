<?php


namespace Study\Application\UseCases\CreateAccount;


final class InputBoundary
{
    /**
     * @var int
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
     * InputBoundary constructor.
     * @param int $person
     * @param float $balance
     * @param string $type
     */
    public function __construct(int $person, float $balance, string $type)
    {
        $this->person = $person;
        $this->balance = $balance;
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getPerson(): int
    {
        return $this->person;
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

}