<?php


namespace Study\Service;


use Study\Domain\Entities\Employee;
/**
 * Class BonusesService
 * @package Study\Service
 */
class BonusesService
{
    /**
     * @var int
     */
    private $total;

    /**
     * @param Employee $employee
     */
    public function countOf(Employee $employee)
    {
        $this->total += $employee->bonus();
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

}