<?php


namespace Study\Service;


use Study\Domain\Entity\Authenticateable;
/**
 * Class AuthService
 * @package Study\Service
 */
class AuthService
{
    /**
     * @param Authenticateable $authenticateable
     * @param string $password
     * @return bool
     */
    public function login(Authenticateable $authenticateable, string $password): bool
    {
        if($authenticateable->isAuthenticate($password)) {
            echo "Logged is success" . PHP_EOL;
            return true;
        } else {
            echo "Password incorrect" . PHP_EOL;
            return false;
        }
    }
}