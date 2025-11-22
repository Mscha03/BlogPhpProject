<?php

namespace App\Models;

use App\Classes\Database;
use App\Exceptions\DoesNotExistsException;

abstract class Model
{
    private Database $database;
    protected string $fileName;
    protected string $entityClass;

    public function __construct()
    {
        $this->database = new Database(fileName: $this->fileName, entityClass: $this->entityClass);
    }

    public function getAllData(): array
    {
        return $this->database->getData();
    }

    /**
     * @throws DoesNotExistsException
     */
    public function getDataById(int $id)
    {
        $data = $this->database->getData();

        $array = array_filter($data, function ($item) use ($id) {
            return $item->getId() === $id;
        });

        $array = array_values($array);

        if (count($array)) {
            return $array[0];
        }
        throw new DoesNotExistsException("Does not exists any {$this->entityClass} ");
    }

    /**
     * @throws DoesNotExistsException
     */
    public function getLastData()
    {
        $data = $this->database->getData();
        uasort($data, function ($first, $second) {
            return $first->getId() > $second->getId() ? -1 : 1;
        });

        $data = array_values($data);

        if (count($data)) {
            return $data[0];
        }

        throw new DoesNotExistsException("Does not exists any {$this->entityClass} ");
    }

    /**
     * @throws DoesNotExistsException
     */
    public function getFirstData()
    {
        $data = $this->database->getData();
        uasort($data, function ($first, $second) {
            return $first->getId() < $second->getId() ? -1 : 1;
        });

        $data = array_values($data);

        if (count($data)) {
            return $data[0];
        }

        throw new DoesNotExistsException("Does not exists any {$this->entityClass} ");
    }

    /**
     * @throws DoesNotExistsException
     */
    public function sortData($callback)
    {

        $data = $this->database->getData();
        uasort($data, $callback);

        $data = array_values($data);

        if (count($data)) {
            return $data;
        }

        throw new DoesNotExistsException("Does not exists any {$this->entityClass} ");
    }

    /**
     * @throws DoesNotExistsException
     */
    public function filterData($callback) {
        $data = $this->database->getData();
        $data = array_filter($data, $callback);

        $data = array_values($data);

        if (count($data)) {
            return $data;
        }

        throw new DoesNotExistsException("Does not exists any {$this->entityClass} ");
    }

    public function createData($new)
    {
        $data = $this->database->getData();
        $data[] = $new;

        $this->database->setData($data);
    }

    public function deleteData($id)
    {
        $data = $this->database->getData();
        $newData = array_filter($data, function ($item) use ($id) {
            return !($item->getId() === $id);
        });

        $newData = array_values($newData);
        $this->database->setData($newData);

        return true;
    }

    public function editData($new)
    {
        $data = $this->database->getData();
        $newData = array_map(function ($item) use ($new) {
            return $item->getId() === $new->getId() ? $new : $item;
        }, $data);

        $newData = array_values($newData);
        $this->database->setData($newData);

        return true;
    }
}