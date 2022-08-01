<?php


namespace Study\Application\UseCases\MakePayment;
/**
 * Class InputBoundary
 * @package Study\Application\UseCases\MakePayment
 */
final class InputBoundary
{
    /**
     * @var int
     */
    private $account;

    /**
     * @var int
     */
    private $employee;

    /**
     * InputBoundary constructor.
     * @param int $account
     * @param int $employee
     */
    public function __construct(int $account, int $employee)
    {
        $this->account = $account;
        $this->employee = $employee;
    }

    /**
     * @return int
     */
    public function getAccount(): int
    {
        return $this->account;
    }

    /**
     * @return int
     */
    public function getEmployee(): int
    {
        return $this->employee;
    }

}