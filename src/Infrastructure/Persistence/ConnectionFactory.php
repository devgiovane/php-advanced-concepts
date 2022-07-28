<?php


namespace Study\Infrastructure\Persistence;


use PDO;
use PDOStatement;
/**
 * Class ConnectionFactory
 * @package Study\Infrastructure\Persistence
 */
class ConnectionFactory
{
    protected static $path = __DIR__ . '/../../../database.sqlite';

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var PDOStatement
     */
    private $statement;

    /**
     * ConnectionFactory constructor.
     */
    public function __construct()
    {
        $this->pdo = null;
        $this->statement = null;
    }

    /**
     *
     */
    public function create(): void
    {
        $this->pdo =  new PDO("sqlite:" . self::$path);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param string $query
     * @return $this
     */
    public function query(string $query): ConnectionFactory
    {
        $this->statement = $this->pdo->query($query);
        return $this;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $query
     * @return $this
     */
    public function prepare(string $query): ConnectionFactory
    {
        $this->statement = $this->pdo->prepare($query);
        return $this;
    }

    /**
     * @param $parameter
     * @param $value
     * @return $this
     */
    public function bind($parameter, $value): ConnectionFactory
    {
        $this->statement->bindValue($parameter, $value);
        return $this;
    }

    /**
     * @return bool
     */
    public function execute(): bool
    {
        try {
            $return = $this->statement->execute();
            if(!$return) {
                print_r($this->pdo->errorInfo());
                print_r($this->statement->errorInfo());
                return false;
            }
            return true;
        } catch (\PDOException $exception) {
            print_r($exception->getMessage());
            return false;
        }
    }

    /**
     * @return int
     */
    public function getLastInsertedId(): int
    {
        return $this->pdo->lastInsertId();
    }

    /**
     *
     */
    public function beginTransaction()
    {
        $this->pdo->beginTransaction();
    }

    /**
     *
     */
    public function commit()
    {
        $this->pdo->commit();
    }

    /**
     *
     */
    public function rollBack()
    {
        $this->pdo->rollBack();
    }

}