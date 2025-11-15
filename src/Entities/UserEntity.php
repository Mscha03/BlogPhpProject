<?php

namespace App\Entities;

class UserEntity
{
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $date;

    /**
     * @param $id
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $password
     * @param $date
     */
    public function __construct($item)
    {
        $this->id = $item['id'];
        $this->firstName = $item['first_name'];
        $this->lastName = $item['last_name'];
        $this->email = $item['email'];
        $this->password = $item['password'];
        $this->date = $item['date'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }


}

