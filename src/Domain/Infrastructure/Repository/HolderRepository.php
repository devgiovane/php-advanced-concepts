<?php


namespace Study\Domain\Infrastructure\Repository;


use Study\Domain\Entity\Holder;
use Study\Domain\Entity\Address;
use Study\Domain\Infrastructure\Persistence\ConnectionFactory;
/**
 * Class HolderRepository
 * @package Study\Domain\Infrastructure\Repository
 */
class HolderRepository implements \Study\Repository\HolderRepository
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
     * @return array|mixed
     */
    public function find(int $id): Holder
    {
        $query = "
            SELECT * FROM person AS p 
            INNER JOIN holder AS h ON p.id = h.id 
            LEFT JOIN address AS a ON h.id_address = a.id
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
            LEFT JOIN address AS a ON h.id_address = a.id;
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
                new Address(
                    (int) $item['id_address'],
                    (string) $item['city'],
                    (string) $item['road'],
                    (int) $item['number']
                )
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

        $isPersonCreated = $isHolderCreated = false;
        $isAddressCreated = $this->addressRepository->save($holder->getAddress());

        if($isAddressCreated) {
            $query = "INSERT INTO person (cpf, name, last_name) VALUES (:cpf, :name, :last_name);";
            $this->connectionFactory->prepare($query)
                ->bind(':cpf', $holder->getCpf())
                ->bind(':name', $holder->getName())
                ->bind(':last_name', $holder->getLastName());

            $isPersonCreated = $this->connectionFactory->execute();
        }

        $idPersonId = $this->connectionFactory->getLastInsertedId();

        if($isPersonCreated) {
            $query = "INSERT INTO holder (id, id_address) VALUES (:id, :id_address)";

            $this->connectionFactory->prepare($query)
                ->bind(':id', $idPersonId)
                ->bind(':id_address', $isAddressCreated);

            $isHolderCreated = $this->connectionFactory->execute();
        }

        if($isHolderCreated) {
            $this->connectionFactory->commit();
            return $idPersonId;
        }

        $this->connectionFactory->rollBack();
        return null;
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