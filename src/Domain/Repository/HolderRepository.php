<?php


namespace Study\Domain\Repository;


use Study\Domain\Entities\Holder;
/**
 * Interface HolderRepository
 * @package Study\Domain\Repository
 */
interface HolderRepository
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
     * @param Holder $holder
     * @return int|null
     */
    public function save(Holder $holder): ?int;

    /**
     * @param Holder $holder
     * @return bool
     */
    public function remove(Holder $holder): bool;
}