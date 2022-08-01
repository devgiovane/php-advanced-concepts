<?php


use Study\Infrastructure\Repository\PersonRepository;
use Study\Infrastructure\Persistence\ConnectionFactory;
use Study\Infrastructure\Repository\AccountCurrentRepository;
use Study\Infrastructure\Cli\Commands\CreateAccountCommand;
use Study\Application\UseCases\CreateAccount\CreateAccount;


require_once 'autoload.php';


$connectionFactory = new ConnectionFactory();
$connectionFactory->create();

$personRepository = new PersonRepository($connectionFactory);
$accountRepository = new AccountCurrentRepository($connectionFactory);

$createAccountUseCase = new CreateAccount($accountRepository, $personRepository);
$createAccountCommand = new CreateAccountCommand($createAccountUseCase);
$response = $createAccountCommand->handle(
    1, 100000, "current"
);
var_dump($response);
$response = $createAccountCommand->handle(
    2, 0, "saving"
);
var_dump($response);
