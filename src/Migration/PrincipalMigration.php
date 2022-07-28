<?php


namespace Study\Migration;


use Study\Infrastructure\Persistence\ConnectionFactory;
/**
 * Class PrincipalMigration
 * @package Study\Migration
 */
final class PrincipalMigration extends Migration implements MigrationInterface
{
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    /**
     * Person constructor.
     */
    public function __construct()
    {
        $this->connectionFactory = new ConnectionFactory();
        $this->connectionFactory->create();
        parent::__construct($this->connectionFactory);
    }

    /**
     *
     */
    public function up(): void
    {
        $query = "
            CREATE TABLE IF NOT EXISTS principal (
                id INTEGER PRIMARY KEY NOT NULL, 
                password TEXT, 
                wage FLOAT, 
                FOREIGN KEY(id) REFERENCES person(id) ON DELETE CASCADE
            );
        ";
        $this->connectionFactory->prepare($query);
        echo "up " . __CLASS__ . ' ' . ($this->connectionFactory->execute() ? 'success' : 'error') . PHP_EOL;
    }

    /**
     *
     */
    public function down(): void
    {
        $this->beforeDown();
        $this->connectionFactory->prepare("DROP TABLE IF EXISTS principal;");
        echo "down " . __CLASS__ . ' ' . ($this->connectionFactory->execute() ? 'success' : 'error') . PHP_EOL;
    }

}