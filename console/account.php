<?php


use Study\Infrastructure\Repository\HolderRepository;
use Study\Infrastructure\Repository\AccountCurrentRepository;
use Study\Infrastructure\Persistence\ConnectionFactory;
use Study\Infrastructure\Cli\Commands\CreateAccountCommand;
use Study\Application\UseCases\CreateAccount\CreateAccount;


require_once 'autoload.php';


$connectionFactory = new ConnectionFactory();
$connectionFactory->create();

$holderRepository = new HolderRepository($connectionFactory);
$accountRepository = new AccountCurrentRepository($connectionFactory);

$createAccountUseCase = new CreateAccount($accountRepository, $holderRepository);
$createAccountCommand = new CreateAccountCommand($createAccountUseCase);
$response = $createAccountCommand->handle();
var_dump($response);