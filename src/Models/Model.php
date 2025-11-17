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

        if(count($array)) {
            return $array[0];
        }
        throw new DoesNotExistsException("Does not exists any {$this->entityClass} ");
    }

    /**
     * @throws DoesNotExistsException
     */
    public function getLastData() {
        $data = $this->database->getData();
        uasort($data, function ($first, $last) {
            return $first->getId() > $last->getId() ? -1 : 1;
        });

        $data = array_values($data);

        if (count($data))
        {
            return $data[0];
        }

        throw new DoesNotExistsException("Does not exists any {$this->entityClass} ");
    }
}