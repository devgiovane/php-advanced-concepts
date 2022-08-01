<?php


use Study\Infrastructure\Repository\HolderRepository;
use Study\Infrastructure\Persistence\ConnectionFactory;
use Study\Infrastructure\Cli\Commands\CreateHolderCommand;
use Study\Application\UseCases\CreateHolder\CreateHolder;


require_once 'autoload.php';


$connectionFactory = new ConnectionFactory();
$connectionFactory->create();

$holderRepository = new HolderRepository($connectionFactory);

$createHolderUseCase = new CreateHolder($holderRepository);
$createHolderCommand = new CreateHolderCommand($createHolderUseCase);
$response = $createHolderCommand->handle(
    "John", "Doe", "475.530.130-05", "Chicago", "La Sale", 1034
);
var_dump($response);