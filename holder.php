<?php


require_once 'autoload.php';


use Study\Domain\Entity\Holder;
use Study\Domain\Entity\Address;
use Study\Service\HolderService;
use Study\Domain\Infrastructure\Persistence\ConnectionFactory;


$address = new Address(null, "Cidade", "Rua", 56);
$holder = new Holder(null, "123.456.789-10", "Giovane", "Silva", $address);

$connectionFactory = new ConnectionFactory();
$holderService = new HolderService($connectionFactory);

//$holderService->create($holder);
$holders = $holderService->listAll();
//$holders = $holderService->listOne(1);
var_dump($holders);
//$holderService->delete(1);