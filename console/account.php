<?php


use Study\Service\HolderService;
use Study\Service\AccountService;
use Study\Domain\Entities\AccountCurrent;
use Study\Infrastructure\Persistence\ConnectionFactory;


require_once 'autoload.php';


$connectionFactory = new ConnectionFactory();

$holderService = new HolderService($connectionFactory);
$gHolderEntity = $holderService->listOne(1);
$jHolderEntity = $holderService->listOne(2);

$accountCurrent = new AccountCurrent(null, $gHolderEntity, 1000);
$accountCurrent->cashDeposit(1000);

$accountSaving = new AccountCurrent(null, $jHolderEntity, 1000);
$accountSaving->cashDeposit(500);

$accountService = new AccountService($connectionFactory);
$accountService->createCurrent($accountCurrent);
$accountService->createCurrent($accountSaving);
$accountCurrentEntities = $accountService->listAllCurrent();
foreach ($accountCurrentEntities as $accountEntity) {
    var_dump($accountEntity->toArray());
}