<?php

require 'vendor/autoload.php';

use App\Templates\CategoryPage;
use App\Templates\MainPage;
use App\Templates\SinglePage;


$page = new CategoryPage();
$page->renderPage();