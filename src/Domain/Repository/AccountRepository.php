<?php


namespace Study\Domain\Repository;


use Study\Domain\Entities\Account;


interface AccountRepository
{
    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int $personID
     * @return mixed
     */
    public function findByPerson(int $personID);

    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param mixed $account
     * @return int|null
     */
    public function save(Account $account): ?int;

    /**
     * @param Account $account
     * @return bool
     */
    public function update(Account $account): bool;

    /**
     * @param Account $account
     * @return bool
     */
    public function remove(Account $account): bool;
}