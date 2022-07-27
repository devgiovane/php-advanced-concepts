<?php


namespace Study\Domain\Repository;


use Study\Domain\Entities\Employee;
/**
 * Interface EmployeeRepository
 * @package Study\Domain\Repository
 */
interface EmployeeRepository
{
    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param Employee $employee
     * @return int|null
     */
    public function save(Employee $employee): ?int;

    /**
     * @param Employee $employee
     * @return bool
     */
    public function remove(Employee $employee): bool;
}