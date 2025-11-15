<?php

namespace App\Classes;

class Database
{
    private string $databaseFileAddress;
    public array $data;

    public function __construct($fileName, $entityClass)
    {
        $this->databaseFileAddress = './database/' . $fileName . '.json';

        $file = fopen($this->databaseFileAddress, 'r+');
        $database = fread($file, filesize($this->databaseFileAddress));
        fclose($file);
        $data = json_decode($database, true);
        $this->data = array_map(function ($item) use ($entityClass) {
            return new ($entityClass)($item);
        }, $data);
    }

}