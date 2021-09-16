<?php


namespace Study\Repository;


use Study\Domain\Entity\AccountCurrent;
/**
 * Interface AccountCurrentRepository
 * @package Study\Repository
 */
interface AccountCurrentRepository
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
     * @param AccountCurrent $accountCurrent
     * @return int|null
     */
    public function save(AccountCurrent $accountCurrent): ?int;

    /**
     * @param AccountCurrent $accountCurrent
     * @return bool
     */
    public function remove(AccountCurrent $accountCurrent): bool;
}