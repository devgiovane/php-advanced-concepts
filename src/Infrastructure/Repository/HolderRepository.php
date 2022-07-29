<?php


namespace Study\Infrastructure\Repository;


use Study\Domain\Entities\Holder;
use Study\Infrastructure\Persistence\ConnectionFactory;
use Study\Domain\Repository\HolderRepository as HolderRepositoryInterface;
/**
 * Class HolderRepository
 * @package Study\Infrastructure\Repository
 */
class HolderRepository implements HolderRepositoryInterface
{
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    /**
     * @var AddressRepository
     */
    private $addressRepository;

    /**
     * HolderRepository constructor.
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
        $this->addressRepository = new AddressRepository($this->connectionFactory);
    }

    /**
     * @param int $id
     * @return Holder
     */
    public function find(int $id): Holder
    {
        $query = "
            SELECT * FROM person AS p 
            INNER JOIN holder AS h ON p.id = h.id 
            WHERE p.id = :id;
        ";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $id);

        $this->connectionFactory->execute();
        return $this->hydrateHolder()[0];
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $query = "
            SELECT * FROM person AS p 
            INNER JOIN holder AS h ON p.id = h.id
        ";
        $this->connectionFactory->query($query);
        return $this->hydrateHolder();
    }

    /**
     * @return array
     */
    private function hydrateHolder(): array
    {
        $holdersList = [];
        $data = $this->connectionFactory->getAll();
        foreach ($data as $item) {
            $holdersList[] = new Holder(
                (int) $item['id'],
                (string) $item['cpf'],
                (string) $item['name'],
                (string) $item['last_name'],
                $this->addressRepository->find((int) $item['address_id']),
                (string) $item['type']
            );
        }
        return $holdersList;
    }

    /**
     * @param Holder $holder
     * @return int|null
     */
    public function save(Holder $holder): ?int
    {
        $this->connectionFactory->beginTransaction();
        $isAddressCreated = $this->addressRepository->save($holder->getAddress());
        if (!$isAddressCreated) {
            $this->connectionFactory->rollBack();
            return null;
        }
        $query = "INSERT INTO person (cpf, name, last_name, type) VALUES (:cpf, :name, :last_name, :type);";
        $this->connectionFactory->prepare($query)
            ->bind(':cpf', $holder->getCpf())
            ->bind(':name', $holder->getName())
            ->bind(':last_name', $holder->getLastName())
            ->bind(':type', $holder->getType());
        $isPersonCreated = $this->connectionFactory->execute();
        if (!$isPersonCreated) {
            $this->connectionFactory->rollBack();
            return null;
        }
        $idPersonId = $this->connectionFactory->getLastInsertedId();
        $query = "INSERT INTO holder (id, address_id) VALUES (:id, :address_id)";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $idPersonId)
            ->bind(':address_id', $isAddressCreated);
        $isHolderCreated = $this->connectionFactory->execute();
        if (!$isHolderCreated) {
            $this->connectionFactory->rollBack();
            return null;
        }
        $this->connectionFactory->commit();
        return $idPersonId;
    }

    /**
     * @param Holder $holder
     * @return bool
     */
    public function remove(Holder $holder): bool
    {
        $query = "DELETE FROM person WHERE id = :id";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $holder->getId());

        return $this->connectionFactory->execute();
    }

}