<?php


namespace Study\Application\UseCases\CreateEmployee;


use Study\Domain\Entities\Employee;
use Study\Domain\Repository\EmployeeRepository;
/**
 * Class CreateEmployee
 * @package Study\Application\UseCases\CreateEmployee
 */
final class CreateEmployee
{
    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * CreateEmployee constructor.
     * @param EmployeeRepository $employeeRepository
     */
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @param InputBoundary $inputBoundary
     * @return OutputBoundary
     */
    public function handle(InputBoundary $inputBoundary): OutputBoundary
    {
        $employee = new Employee(
            null, $inputBoundary->getCpf(), $inputBoundary->getName(), $inputBoundary->getLastName(),
            $inputBoundary->getOffice(), $inputBoundary->getWage()
        );
        $idSaved = $this->employeeRepository->save($employee);
        return new OutputBoundary($idSaved);
    }

}