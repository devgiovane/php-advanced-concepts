<?php


namespace Study\Domain\Repository;


use Study\Domain\Entities\Principal;
/**
 * Interface PrincipalRepository
 * @package Study\Domain\Repository
 */
interface PrincipalRepository
{
    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param Principal $principal
     * @return int|null
     */
    public function save(Principal $principal): ?int;

    /**
     * @param Principal $principal
     * @return bool
     */
    public function remove(Principal $principal): bool;
}