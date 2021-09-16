<?php


namespace Study\Migration;
/**
 * Interface MigrationInterface
 * @package Study\Migration
 */
interface MigrationInterface
{
    /**
     *
     */
    public function up(): void;

    /**
     *
     */
    public function down(): void;
}