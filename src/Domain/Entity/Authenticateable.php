<?php


namespace Study\Domain\Entity;


interface Authenticateable
{
    /**
     * @param string $password
     * @return bool
     */
    public function isAuthenticate(string $password): bool;
}