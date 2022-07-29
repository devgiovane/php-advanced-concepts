<?php


namespace Study\Infrastructure\Repository;


use Study\Domain\Entities\Person;
use Study\Infrastructure\Persistence\ConnectionFactory;
use Study\Domain\Repository\PersonRepository as PersonRepositoryInterface;
/**
 * Class PersonRepository
 * @package Study\Infrastructure\Repository
 */
class PersonRepository implements PersonRepositoryInterface
{
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }

    /**
     * @param int $id
     * @return mixed|null
     * @throws \Exception
     */
    public function find(int $id)
    {
        $query = "
            SELECT type FROM person WHERE id = :id;
        ";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $id);;
        $this->connectionFactory->execute();
        $data = $this->connectionFactory->getOne();
        if (!$data) {
            throw new \Exception('Person not found');
        }
        foreach (Person::TYPES as $type => $class) {
            if ($data['type'] === $type) {
                $repository = new $class($this->connectionFactory);
                return $repository->find($id);
            }
        }
        return null;
    }

    /**
     * @param Person $person
     * @return int|null
     */
    public function save(Person $person): ?int
    {
        foreach (Person::TYPES as $type => $class) {
            if ($person instanceof $class) {
                $repository = new $class($this->connectionFactory);
                return $repository->save($person);
            }
        }
        return null;
    }

    /**
     * @param Person $person
     * @return bool
     */
    public function remove(Person $person): bool
    {
        $query = "DELETE FROM person WHERE id = :id";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $person->getId());

        return $this->connectionFactory->execute();
    }
}