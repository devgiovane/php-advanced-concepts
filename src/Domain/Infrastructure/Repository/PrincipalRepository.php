<?php


namespace Study\Domain\Infrastructure\Repository;


use Study\Domain\Entity\Principal;
use Study\Domain\Infrastructure\Persistence\ConnectionFactory;
/**
 * Class PrincipalRepository
 * @package Study\Domain\Infrastructure\Repository
 */
class PrincipalRepository implements \Study\Repository\PrincipalRepository
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
     * @return mixed
     */
    public function find(int $id): Principal
    {
        $query = "
            SELECT * FROM person AS p 
            INNER JOIN principal AS pp ON p.id = pp.id 
            WHERE p.id = :id;
        ";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $id);

        $this->connectionFactory->execute();
        return $this->hydratePrincipal()[0];
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $query = "
            SELECT * FROM person AS p 
            INNER JOIN principal AS pp ON p.id = pp.id;
        ";
        $this->connectionFactory->query($query);
        return $this->hydratePrincipal();
    }

    /**
     * @return array
     */
    private function hydratePrincipal(): array
    {
        $principalList = [];
        $data = $this->connectionFactory->getAll();
        foreach ($data as $item) {
            $principalList[] = new Principal(
                (int) $item['id'],
                (string) $item['cpf'],
                (string) $item['name'],
                (string) $item['last_name'],
                (string) $item['password'],
                (float) $item['wage']
            );
        }
        return $principalList;
    }

    /**
     * @param Principal $principal
     * @return int|null
     */
    public function save(Principal $principal): ?int
    {
        $this->connectionFactory->beginTransaction();

        $isPrincipalCreated = false;

        $query = "INSERT INTO person (cpf, name, last_name) VALUES (:cpf, :name, :last_name);";
        $this->connectionFactory->prepare($query)
            ->bind(':cpf', $principal->getCpf())
            ->bind(':name', $principal->getName())
            ->bind(':last_name', $principal->getLastName());

        $isPersonCreated = $this->connectionFactory->execute();

        $idPersonId = $this->connectionFactory->getLastInsertedId();

        if($isPersonCreated) {
            $query = "INSERT INTO principal (id, password, wage) VALUES (:id, :password, :wage)";
            $this->connectionFactory->prepare($query)
                ->bind(':id', $idPersonId)
                ->bind(':password', $principal->getPassword())
                ->bind(':wage', $principal->getWage());

            $isPrincipalCreated = $this->connectionFactory->execute();
        }

        if($isPrincipalCreated) {
            $this->connectionFactory->commit();
            return $idPersonId;
        }

        $this->connectionFactory->rollBack();
        return null;
    }

    /**
     * @param Principal $principal
     * @return bool
     */
    public function remove(Principal $principal): bool
    {
        $query = "DELETE FROM person WHERE id = :id";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $principal->getId());

        return $this->connectionFactory->execute();
    }

}