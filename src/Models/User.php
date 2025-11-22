?php

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
}