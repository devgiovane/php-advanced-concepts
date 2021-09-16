<?php


namespace Study\Repository;


use Study\Domain\Entity\Holder;
/**
 * Interface HolderRepository
 * @package Study\Repository
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