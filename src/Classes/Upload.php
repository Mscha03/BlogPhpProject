<?php

namespace App\Classes;

class Upload
{
    private const string UPLOAD_DIR = './assets/images/';
    private string $name;
    private string $type;
    private int $size;
    private string $tmp;
    private string $extension;

    public function __construct(array $array)
    {
        $this->name = $array['name'];
        $this->type = $array['type'];
        $this->size = $array['size'];
        $this->tmp = $array['tmp_name'];
        $this->extension = pathinfo($this->name, PATHINFO_EXTENSION);
    }

    public function upload(): false|string
    {
        $newName = $this->name . '.' . $this->extension;
        $address = self::UPLOAD_DIR . $newName;

        if (move_uploaded_file($this->tmp, $address)) {
            return "images/$newName";
        }

        return false;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getSize(): int
    {
        return $this->size / 1024;
    }

    public function getTmp(): string
    {
        return $this->tmp;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function isFile(): bool
    {
        return  $this->name != '';
    }
}