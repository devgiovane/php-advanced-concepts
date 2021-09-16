<?php


require_once 'autoload.php';


use Study\Service\AuthService;
use Study\Domain\Entity\Principal;
use Study\Service\PrincipalService;
use Study\Domain\Infrastructure\Persistence\ConnectionFactory;


$principal = new Principal(null, "123.456.789-10", "Giovane", "Santos Silva", "rj4it9w", 3000);

$connectionFactory = new ConnectionFactory();
$principalService = new PrincipalService($connectionFactory);

//$principalService->create($principal);
$principals = $principalService->listOne(3);
var_dump($principals);

$authService = new AuthService();
$isLogged = $authService->login($principal, "rj4it9w");
var_dump($isLogged);