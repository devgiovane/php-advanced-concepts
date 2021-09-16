<?php



require_once 'autoload.php';


use Study\Domain\Entity\Employee;
use Study\Service\BonusesService;
use Study\Service\EmployeeService;
use Study\Domain\Infrastructure\Persistence\ConnectionFactory;


$employee = new Employee(null, "123.456.789-10", "Giovane", "Silva", "Developer", 2100);
$connectionFactory = new ConnectionFactory();
$employeeService = new EmployeeService($connectionFactory);

//$employeeService->create($employee);

$employee0 = $employeeService->listOne(4);
$employee1 = $employeeService->listOne(5);

$bonusService = new BonusesService();
$bonusService->countOf($employee0);
$bonusService->countOf($employee1);
echo $bonusService->getTotal() . PHP_EOL;