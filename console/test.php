<?php


use Study\Infrastructure\Persistence\ConnectionFactory;
use Study\Infrastructure\Repository\AccountCurrentRepository;
use Study\Infrastructure\Repository\HolderRepository;


require_once 'autoload.php';


$connectionFactory = new ConnectionFactory();
$connectionFactory->create();

$holderRepository = new HolderRepository($connectionFactory);
var_dump($holderRepository->findAll());

$accountRepository = new AccountCurrentRepository($connectionFactory);
var_dump($accountRepository->findAll());
