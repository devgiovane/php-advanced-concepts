<?php


use Study\Domain\Entities\Address;
use Study\Domain\Entities\Holder;
use Study\Service\HolderService;
use Study\Infrastructure\Persistence\ConnectionFactory;


require_once 'autoload.php';


$connectionFactory = new ConnectionFactory();

$gAddress = new Address(null, "São Paulo", "Rua Antônio Briochi", 56);
$gHolder = new Holder(null, "280.190.710-32", "Giovane", "Silva", $gAddress);

$jAddress = new Address(null, "João Pessoa", "Rua do Norte", 134);
$jHolder = new Holder(null, "524.056.190-75", "Jonas", "Silva", $jAddress);

$holderService = new HolderService($connectionFactory);
$holderService->create($gHolder);
$holderService->create($jHolder);
$holderEntities = $holderService->listAll();
foreach ($holderEntities as $holderEntity) {
    var_dump($holderEntity->toArray());
}