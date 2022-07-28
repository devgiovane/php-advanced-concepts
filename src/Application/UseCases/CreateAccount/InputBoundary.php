<?php


namespace Study\Application\UseCases\CreateAccount;


final class InputBoundary
{
    /**
     * @var int
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
     * InputBoundary constructor.
     * @param int $holder
     * @param float $balance
     * @param string $type
     */
    public function __construct(int $holder, float $balance, string $type)
    {
        $this->holder = $holder;
        $this->balance = $balance;
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getHolder(): int
    {
        return $this->holder;
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