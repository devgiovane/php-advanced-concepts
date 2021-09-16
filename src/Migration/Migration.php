<?php


namespace Study\Migration;


use Study\Domain\Infrastructure\Persistence\ConnectionFactory;
/**
 * Class Migration
 * @package Study\Migration
 */
class Migration
{
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    /**
     * MigrationBefore constructor.
     *
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }

    /**
     *
     */
    protected function beforeDown(): void
    {
        $this->connectionFactory->prepare("PRAGMA foreign_keys=OFF;");
        echo "beforeDown " . $this->connectionFactory->execute() . PHP_EOL;
    }
}