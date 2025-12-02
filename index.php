<?php

use App\Templates\MainPage;
use App\Templates\SinglePage;

require 'vendor/autoload.php';

$page = new SinglePage();
$page->renderPage();