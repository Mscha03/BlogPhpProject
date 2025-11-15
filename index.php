<?php

require 'vendor/autoload.php';

use App\Classes\Database;
use App\Entities\PostEntity;

$database = new Database('posts', PostEntity::class);
dd($database->data);