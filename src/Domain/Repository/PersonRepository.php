<?php


namespace Study\Domain\Repository;
use Study\Domain\Entities\Person;

/**
 * Interface PersonRepository
 * @package Study\Domain\Repository
 */
interface PersonRepository
{
    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param Person $person
     * @return int|null
     */
    public function save(Person $person): ?int;

    /**
     * @param Person $person
     * @return bool
     */
    public function remove(Person $person): bool;
}