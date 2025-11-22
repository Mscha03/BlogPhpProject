<?php

namespace App\Models;

use App\Classes\Database;
use App\Exceptions\DoesNotExistsException;

/**
 * Abstract base model for database operations
 *
 * Provides CRUD operations and query methods for entity models
 */
abstract class Model
{
    private Database $database;
    protected string $fileName;
    protected string $entityClass;

    public function __construct()
    {
        $this->database = new Database(
            fileName: $this->fileName,
            entityClass: $this->entityClass);
    }

    /**
     * Get all data from database
     *
     * @return array Array of entity objects
     */
    public function getAllData(): array
    {
        return $this->database->getData();
    }

    /**
     * Find entity by ID
     *
     * @param int $id Entity ID
     * @return object Entity object
     * @throws DoesNotExistsException If entity not found
     */
    public function getDataById(int $id): object
    {
        $data = $this->database->getData();

        $filtered  = array_filter(
            $data,
            fn($item) => $item->getId() === $id
        );

        if (empty($filtered)) {
            throw new DoesNotExistsException(
                "Entity with ID {$id} does not exist in {$this->entityClass}"
            );
        }

        return array_values($filtered)[0];
    }

    /**
     * Get entity with highest ID
     *
     * @return object Entity object
     * @throws DoesNotExistsException If no data exists
     */
    public function getLastData(): object
    {
        $data = $this->database->getData();

        if (empty($data)) {
            throw new DoesNotExistsException(
                "No data exists in {$this->entityClass}"
            );
        }

        uasort(
            $data,
            fn($first, $second) => $second->getId() <=> $first->getId()
        );

        return $data[0];
    }

    /**
     * Get entity with lowest ID
     *
     * @return object Entity object
     * @throws DoesNotExistsException If no data exists
     */
    public function getFirstData(): object
    {
        $data = $this->database->getData();

        if (empty($data)) {
            throw new DoesNotExistsException(
                "No data exists in {$this->entityClass}"
            );
        }

        usort(
            $data,
            fn($first, $second) => $first->getId() <=> $second->getId()
        );

        return $data[0];
    }

    /**
     * Sort data with custom callback
     *
     * @param callable $callback Sort comparison function
     * @return array Sorted array of entities
     * @throws DoesNotExistsException If no data exists
     */
    public function sortData(callable $callback): array
    {
        $data = $this->database->getData();

        if (empty($data)) {
            throw new DoesNotExistsException(
                "No data exists in {$this->entityClass}"
            );
        }

        usort($data, $callback);

        return $data;
    }

    /**
     * Filter data with custom callback
     *
     * @param callable $callback Filter function
     * @return array Filtered array of entities
     * @throws DoesNotExistsException If no matching data found
     */
    public function filterData(callable $callback): array
    {
        $data = $this->database->getData();
        $filtered = array_filter($data, $callback);

        if (empty($filtered)) {
            throw new DoesNotExistsException(
                "No matching data found in {$this->entityClass}"
            );
        }

        return array_values($filtered);
    }

    /**
     * Create new entity
     *
     * @param object $newEntity Entity object to create
     * @return void
     */
    public function createData(object $newEntity): void
    {
        $data = $this->database->getData();
        $data[] = $newEntity;
        $this->database->setData($data);
    }

    /**
     * Delete entity by ID
     *
     * @param int $id Entity ID to delete
     * @return bool True on success
     */
    public function deleteData(int $id): bool
    {
        $data = $this->database->getData();

        $newData = array_values(
            array_filter(
                $data,
                fn($item) => $item->getId() !== $id
            )
        );

        $this->database->setData($newData);

        return true;
    }

    /**
     * Update existing entity
     *
     * @param object $updatedEntity Updated entity object
     * @return bool True on success
     */
    public function editData(object $updatedEntity): bool
    {
        $data = $this->database->getData();

        $newData = array_values(
            array_map(
                fn($item) => $item->getId() === $updatedEntity->getId()
                    ? $updatedEntity
                    : $item,
                $data
            )
        );

        $this->database->setData($newData);

        return true;
    }
}