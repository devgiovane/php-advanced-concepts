<?php


namespace Study\Repository;


use Study\Domain\Entity\Address;
/**
 * Interface AddressRepository
 * @package Study\Repository
 */
interface AddressRepository
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
     * @param Address $address
     * @return int|null
     */
    public function save(Address $address): ?int;

    /**
     * @param Address $address
     * @return bool
     */
    public function remove(Address $address): bool;
}