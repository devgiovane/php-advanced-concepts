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
$response = $createHolderCommand->handle();
var_dump($response);