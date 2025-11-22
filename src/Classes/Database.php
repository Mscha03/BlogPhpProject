<?php

namespace App\Classes;

use RuntimeException;
use InvalidArgumentException;

/**
 * JSON-based database handler
 *
 * Manages reading and writing data to JSON files with entity mapping
 */
class Database
{
    private const DATABASE_DIR = './database/';
    private const FILE_EXTENSION = '.json';

    private string $databaseFileAddress;
    private array $data;
    private string $entityClass;

    /**
     * Initialize database with file and entity class
     *
     * @param string $fileName Name of the database file (without extension)
     * @param string $entityClass Fully qualified class name for entity mapping
     * @throws RuntimeException If file operations fail
     * @throws InvalidArgumentException If entity class doesn't exist
     */
    public function __construct(string $fileName, $entityClass)
    {
        if (!class_exists($entityClass)) {
            throw new InvalidArgumentException("Entity class {$entityClass} does not exist");
        }

        $this->entityClass = $entityClass;
        $this->databaseFileAddress = self::DATABASE_DIR . $fileName . self::FILE_EXTENSION;

        $this->ensureDatabaseDirectoryExists();

        $file = fopen($this->databaseFileAddress, 'r+');
        $database = fread($file, filesize($this->databaseFileAddress));
        fclose($file);
        $data = json_decode($database, true);
        $this->data = array_map(function ($item) use ($entityClass) {
            return new ($entityClass)($item);
        }, $data);
    }

    /**
     * Set new data and persist to file
     *
     * @param array $newData Array of entity objects
     * @return array Array representation of stored data
     * @throws RuntimeException If persistence fails
     */
    public function setData(array $newData): array
    {
        $this->data = $newData;

        $newData = array_map(function ($item) {
            return $item->toArray();
        }, $newData);

        $file = fopen($this->databaseFileAddress, 'w+');
        fwrite($file, json_encode($newData));
        fclose($file);

        return $newData;
    }

    /**
     * Get all data as entity objects
     *
     * @return array Array of entity objects
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Ensure database directory exists
     *
     * @throws RuntimeException If directory cannot be created
     */
    private function ensureDatabaseDirectoryExists(): void
    {
        if (!is_dir(self::DATABASE_DIR)) {
            if (!mkdir(self::DATABASE_DIR, 0755, true) && !is_dir(self::DATABASE_DIR)) {
                throw new RuntimeException("Failed to create database directory");
            }
        }
    }

}