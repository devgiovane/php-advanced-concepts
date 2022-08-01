<?php


use Study\Infrastructure\Persistence\ConnectionFactory;
use Study\Infrastructure\Repository\EmployeeRepository;
use Study\Infrastructure\Cli\Commands\CreateEmployeeCommand;
use Study\Application\UseCases\CreateEmployee\CreateEmployee;


require_once 'autoload.php';


$connectionFactory = new ConnectionFactory();
$connectionFactory->create();

$employeeRepository = new EmployeeRepository($connectionFactory);
$createEmployeeUseCase = new CreateEmployee($employeeRepository);
$createEmployeeCommand = new CreateEmployeeCommand($createEmployeeUseCase);
$response = $createEmployeeCommand->handle(
    "Giovane", "Silva", "401.881.720-76", "Developer", 3500.00
);
var_dump($response);