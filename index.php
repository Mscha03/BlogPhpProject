<?php

require 'vendor/autoload.php';

use App\Classes\Request;
use App\Exceptions\DoesNotExistsException;
use App\Exceptions\NotFoundException;
use App\Templates\CategoryPage;
use App\Templates\ErrorPage;
use App\Templates\LoginPage;
use App\Templates\MainPage;
use App\Templates\NotFoundPage;
use App\Templates\SearchPage;
use App\Templates\SinglePage;

$page = null;
try {
    $request = new Request();
    switch ($request->get('action')) {
        case 'single':
            $page = new SinglePage();
            break;
        case 'search':
            $page = new SearchPage();
            break;
        case 'category':
            $page = new CategoryPage();
            break;
        case 'login':
            $page = new LoginPage();
            break;
        case null:
            $page = new MainPage();
            break;
        default:
            throw new NotFoundException();
    }
} catch (DoesNotExistsException | NotFoundException $e) {
    $page = new NotFoundPage($e->getMessage());
} catch (Exception $e) {
    $page = new ErrorPage($e->getMessage());
} finally {
    $page->renderPage();
}
