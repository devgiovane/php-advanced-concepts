<?php


use Study\Infrastructure\Persistence\ConnectionFactory;
use Study\Infrastructure\Repository\PersonRepository;
use Study\Infrastructure\Repository\AccountCurrentRepository;
use Study\Infrastructure\Repository\AccountSavingRepository;
use Study\Infrastructure\Cli\Commands\MakePaymentCommand;
use Study\Application\UseCases\MakePayment\MakePayment;


require_once 'autoload.php';


$connectionFactory = new ConnectionFactory();
$connectionFactory->create();

$personRepository = new PersonRepository($connectionFactory);
$accountCurrentRepository = new AccountCurrentRepository($connectionFactory);
$accountSavingsRepository = new AccountSavingRepository($connectionFactory);

$makePaymentUseCase = new MakePayment($personRepository, $accountCurrentRepository, $accountSavingsRepository);
$makePaymentCommand = new MakePaymentCommand($makePaymentUseCase);
$response = $makePaymentCommand->handle(1, 2);
var_dump($response);
