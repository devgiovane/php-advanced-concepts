<?php


namespace Study\Service;


use Study\Domain\Entity\Employee;
use Study\Domain\Infrastructure\Persistence\ConnectionFactory;
use Study\Domain\Infrastructure\Repository\EmployeeRepository;
/**
 * Class EmployeeService
 * @package Study\Service
 */
class EmployeeService
{
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * HolderService constructor.
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
        $this->connectionFactory->create();
        $this->employeeRepository = new EmployeeRepository($this->connectionFactory);
    }

    /**
     * @param int $id
     * @return Employee
     */
    public function listOne(int $id): Employee
    {
        return $this->employeeRepository->find($id);
    }

    /**
     * @return array
     */
    public function listAll(): array
    {
        return $this->employeeRepository->findAll();
    }

    /**
     * @param Employee $employee
     * @return int|null
     */
    public function create(Employee $employee): ?int
    {
        return $this->employeeRepository->save($employee);
    }

    /**
     * @param Employee $employee
     * @return bool
     */
    public function delete(Employee $employee): bool
    {
        return $this->employeeRepository->remove($employee);
    }

}