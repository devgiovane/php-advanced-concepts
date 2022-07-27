<?php


namespace Study\Domain\Entities;


interface Authenticateable
{
    /**
     * @param string $password
     * @return bool
     */
    public function isAuthenticate(string $password): bool;
}