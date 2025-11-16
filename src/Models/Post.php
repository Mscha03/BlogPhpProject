<?php

namespace App\Models;

use App\Entities\PostEntity;

class Post extends Model
{
    protected string $fileName = 'posts';
    protected string $entityClass = PostEntity::class;
}