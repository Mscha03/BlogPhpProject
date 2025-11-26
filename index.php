<?php

use App\Templates\MainPage;

require 'vendor/autoload.php';

$page = new MainPage();
$page->renderPage();