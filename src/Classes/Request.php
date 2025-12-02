<?php

namespace App\Classes;

class Request
{
    private array $attributes = [];
    private string $method;
    private string $url;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        if($this->method === 'POST'){
            foreach ($_POST as $key => $value) {
                $this->attributes[$key] = $value;
            }

            foreach ($_FILES as $key => $value) {
                $this->attributes[$key] = $value;
            }
        } else {
            foreach ($_GET as $key => $value) {
                $this->attributes[$key] = $value;
            }
        }
    }

    public function _get(string $name)
    {
        if(array_key_exists($name, $this->attributes)){
            return $this->attributes[$name];
        }
        return null;
    }

    public function has(string $name): bool
    {
        if(isset($this->attributes[$name])){
            return true;
        }
        return false;
    }

    public function get(string $name)
    {
        if(array_key_exists($name, $this->attributes)){
            return $this->attributes[$name];
        }
        return null;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}