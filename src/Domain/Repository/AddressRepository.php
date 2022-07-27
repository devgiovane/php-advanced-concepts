<?php


namespace Study\Domain\Repository;


use Study\Domain\Entities\Address;
/**
 * Interface AddressRepository
 * @package Study\Domain\Repository
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