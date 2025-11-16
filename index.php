<?php

require 'vendor/autoload.php';

use App\Classes\Database;
use App\Entities\PostEntity;
use App\Models\Post;

$post = new Post();
dd($post->getAllData());