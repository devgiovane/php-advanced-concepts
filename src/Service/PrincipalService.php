<?php


namespace Study\Service;


use Study\Domain\Entities\Principal;
use Study\Infrastructure\Persistence\ConnectionFactory;
use Study\Infrastructure\Repository\PrincipalRepository;
/**
 * Class PrincipalService
 * @package Study\Service
 */
class PrincipalService
{
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    /**
     * @var PrincipalRepository
     */
    private $principalRepository;

    /**
     * HolderService constructor.
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
        $this->connectionFactory->create();
        $this->principalRepository = new PrincipalRepository($this->connectionFactory);
    }

    /**
     * @param int $id
     * @return Principal
     */
    public function listOne(int $id): Principal
    {
        return $this->principalRepository->find($id);
    }

    /**
     * @return array
     */
    public function listAll(): array
    {
        return $this->principalRepository->findAll();
    }

    /**
     * @param Principal $principal
     * @return int|null
     */
    public function create(Principal $principal): ?int
    {
        return $this->principalRepository->save($principal);
    }

    /**
     * @param Principal $principal
     * @return bool
     */
    public function delete(Principal $principal): bool
    {
        return $this->principalRepository->remove($principal);
    }

}