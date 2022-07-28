<?php


namespace Study\Infrastructure\Repository;


use Study\Domain\Entities\Address;
use Study\Infrastructure\Persistence\ConnectionFactory;
/**
 * Class AddressRepository
 * @package Study\Infrastructure\Repository
 */
class AddressRepository implements \Study\Domain\Repository\AddressRepository
{
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    /**
     * HolderRepository constructor.
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }

    /**
     * @param int $id
     * @return Address
     */
    public function find(int $id): Address
    {
        $query = "SELECT * FROM address WHERE id = :id;";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $id);

        $this->connectionFactory->execute();
        return $this->hydrateAddress()[0];
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $query = "SELECT * FROM address;";
        $this->connectionFactory->query($query);
        return $this->hydrateAddress();
    }

    /**
     * @return array
     */
    private function hydrateAddress(): array
    {
        $holdersList = [];
        $data = $this->connectionFactory->getAll();
        foreach ($data as $item) {
            $holdersList[] = new Address(
                (int) $item['id'],
                (string) $item['city'],
                (string) $item['road'],
                (int) $item['number']
            );
        }
        return $holdersList;
    }

    /**
     * @param Address $address
     * @return int|null
     */
    public function save(Address $address): ?int
    {
        $query = "INSERT INTO address (city, road, number) VALUES (:city, :road, :number);";
        $this->connectionFactory->prepare($query)
            ->bind(':city', $address->getCity())
            ->bind(':road', $address->getRoad())
            ->bind(':number', $address->getNumber());

        $isAddressCreated = $this->connectionFactory->execute();
        if($isAddressCreated) {
            return $this->connectionFactory->getLastInsertedId();
        }
        return null;
    }

    /**
     * @param Address $address
     * @return bool
     */
    public function remove(Address $address): bool
    {
        $query = "DELETE FROM address WHERE id = :id";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $address->getId());

        return $this->connectionFactory->execute();
    }

}