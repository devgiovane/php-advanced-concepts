<?php


namespace Study\Migration;


use Study\Infrastructure\Persistence\ConnectionFactory;
/**
 * Class HolderMigration
 * @package Study\Migration
 */
final class HolderMigration extends Migration implements MigrationInterface
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
            CREATE TABLE IF NOT EXISTS holder (
                id INTEGER PRIMARY KEY NOT NULL, 
                address_id INT NOT NULL, 
                FOREIGN KEY(id) REFERENCES person(id) ON DELETE CASCADE, 
                FOREIGN KEY(address_id) REFERENCES address(id) ON DELETE SET NULL
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
        $this->connectionFactory->prepare("DROP TABLE IF EXISTS holder;");
        echo "down " . __CLASS__ . ' ' . ($this->connectionFactory->execute() ? 'success' : 'error') . PHP_EOL;
    }

}