<?php


require_once 'autoload.php';


use Study\Service\HolderService;
use Study\Service\AccountService;
use Study\Domain\Entity\AccountSaving;
use Study\Domain\Entity\AccountCurrent;
use Study\Domain\Infrastructure\Persistence\ConnectionFactory;


$connectionFactory = new ConnectionFactory();
$holderService = new HolderService($connectionFactory);
$accountService = new AccountService($connectionFactory);

$holder = $holderService->listOne(1);
var_dump($holder->getFullName());
if($holder) {
    $accountCurrent = new AccountCurrent(null, $holder, 1000);
    $accountSaving = new AccountSaving(null, $holder, 1000);
//    $accountService->createCurrent($accountCurrent);
//    $accountService->createSaving($accountSaving);
    var_dump($accountService->listAllCurrent());
    var_dump($accountService->listAllSaving());
}