<?php


use Study\Infrastructure\Persistence\ConnectionFactory;
use Study\Infrastructure\Repository\AccountCurrentRepository;


require_once 'autoload.php';


$connectionFactory = new ConnectionFactory();
$connectionFactory->create();

$accountCurrentRepository = new AccountCurrentRepository($connectionFactory);
var_dump($accountCurrentRepository->findAll());