<?php


use Study\Migration\AddressMigration;
use Study\Migration\PersonMigration;
use Study\Migration\HolderMigration;
use Study\Migration\EmployeeMigration;
use Study\Migration\PrincipalMigration;
use Study\Migration\AccountMigration;
use Study\Migration\AccountCurrentMigration;
use Study\Migration\AccountSavingMigration;


require_once 'autoload.php';


$migrations = array(
    new AddressMigration(),
    new PersonMigration(),
    new HolderMigration(),
    new EmployeeMigration(),
    new PrincipalMigration(),
    new AccountMigration(),
    new AccountCurrentMigration(),
    new AccountSavingMigration(),
);

$option = 'up';
if ($argc >= 2) {
    $option = $argv[1];
}

foreach ($migrations as $migration) {
    $option === 'up' ? $migration->up() : $migration->down();
}