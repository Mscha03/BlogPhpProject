<?php

namespace App\Models;

use App\Entities\UserEntity;

/**
* User model
*
* Handles database operations for users
*/
final class User extends Model
{
    protected string $fileName = 'users';
    protected string $entityClass = UserEntity::class;

    public function authenticateUser(string $email, string $password)
    {
        $data = $this->database->getData();
        $user = array_filter($data, function ($item) use ($email, $password) {
            return ($item->getEmail() === $email && $item->getPassword() === $password);
        });

        $user = array_values($user);

        if (count($user)) {
            return $user[0];
        }

        return false;
    }
}