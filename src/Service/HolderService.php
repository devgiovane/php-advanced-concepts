<?php


namespace Study\Service;


use Study\Domain\Entities\Holder;
use Study\Infrastructure\Repository\HolderRepository;
use Study\Infrastructure\Persistence\ConnectionFactory;
/**
 * Class HolderService
 * @package Study\Service
 */
class HolderService
{
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    /**
     * @var HolderRepository
     */
    private $holderRepository;

    /**
     * HolderService constructor.
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
        $this->connectionFactory->create();
        $this->holderRepository = new HolderRepository($this->connectionFactory);
    }

    /**
     * @param int $id
     * @return Holder
     */
    public function listOne(int $id): Holder
    {
        return $this->holderRepository->find($id);
    }

    /**
     * @return array
     */
    public function listAll(): array
    {
        return $this->holderRepository->findAll();
    }

    /**
     * @param Holder $holder
     * @return int|null
     */
    public function create(Holder $holder): ?int
    {
        return $this->holderRepository->save($holder);
    }

    /**
     * @param Holder $holder
     * @return bool
     */
    public function delete(Holder $holder): bool
    {
        return $this->holderRepository->remove($holder);
    }

}