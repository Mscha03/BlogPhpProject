<?php

namespace App\Models;

use App\Entities\UserEntity;

class User extends Model
{
    protected string $fileName = 'users';
    protected string $entityClass = UserEntity::class;
}