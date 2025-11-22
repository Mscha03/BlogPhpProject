<?php

namespace App\Models;

use App\Entities\PostEntity;

/**
 * Post model
 *
 * Handles database operations for blog posts
 */
final class Post extends Model
{
    protected string $fileName = 'posts';
    protected string $entityClass = PostEntity::class;
}