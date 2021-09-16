<?php


require_once 'autoload.php';


$address = new \Study\Migration\AddressMigration();
$address->up();

$person = new \Study\Migration\PersonMigration();
$person->up();

$holder = new \Study\Migration\HolderMigration();
$holder->up();

$employee = new \Study\Migration\EmployeeMigration();
$employee->up();

$principal = new \Study\Migration\PrincipalMigration();
$principal->up();

$account = new \Study\Migration\AccountMigration();
$account->up();

$accountCurrent = new \Study\Migration\AccountCurrentMigration();
$accountCurrent->up();

$accountSaving = new \Study\Migration\AccountSavingMigration();
$accountSaving->up();