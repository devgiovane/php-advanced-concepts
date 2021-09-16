<?php


namespace Study\Repository;


use Study\Domain\Entity\AccountSaving;
/**
 * Interface AccountSavingRepository
 * @package Study\Repository
 */
interface AccountSavingRepository
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
     * @param AccountSaving $accountSaving
     * @return int|null
     */
    public function save(AccountSaving $accountSaving): ?int;

    /**
     * @param AccountSaving $accountSaving
     * @return bool
     */
    public function remove(AccountSaving $accountSaving): bool;
}