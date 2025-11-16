<?php

require 'vendor/autoload.php';

use App\Models\Post;

$post = new Post();
dd($post->getAllData());