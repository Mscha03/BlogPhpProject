<?php

namespace App\Classes;

class Database
{
    private string $databaseFileAddress;
    private array $data;

    public function __construct(string $fileName, $entityClass)
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

    public function getData(): array
    {
        return $this->data;
    }
}