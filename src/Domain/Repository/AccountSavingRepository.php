<?php


namespace Study\Domain\Repository;


use Study\Domain\Entities\AccountSaving;
/**
 * Interface AccountSavingRepository
 * @package Study\Domain\Repository
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