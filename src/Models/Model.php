<?php

namespace App\Models;

use App\Classes\Database;

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
}