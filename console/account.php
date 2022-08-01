<?php


use Study\Infrastructure\Repository\PersonRepository;
use Study\Infrastructure\Persistence\ConnectionFactory;
use Study\Infrastructure\Repository\AccountSavingRepository;
use Study\Infrastructure\Repository\AccountCurrentRepository;
use Study\Infrastructure\Cli\Commands\CreateAccountCommand;
use Study\Application\UseCases\CreateAccount\CreateAccount;


require_once 'autoload.php';


$connectionFactory = new ConnectionFactory();
$connectionFactory->create();

$personRepository = new PersonRepository($connectionFactory);

$accountCurrentRepository = new AccountCurrentRepository($connectionFactory);
$createAccountCurrentUseCase = new CreateAccount($accountCurrentRepository, $personRepository);
$createAccountCurrentCommand = new CreateAccountCommand($createAccountCurrentUseCase);
$response = $createAccountCurrentCommand->handle(
    1, 100000, "current"
);
var_dump($response);

$accountSavingRepository = new AccountSavingRepository($connectionFactory);
$createAccountSavingUseCase = new CreateAccount($accountSavingRepository, $personRepository);
$createAccountSavingCommand = new CreateAccountCommand($createAccountSavingUseCase);
$response = $createAccountSavingCommand->handle(
    2, 0, "saving"
);
var_dump($response);
