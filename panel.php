<?php

use App\Classes\Auth;
use App\Classes\Request;
use App\Exceptions\DoesNotExistsException;
use App\Exceptions\NotFoundException;
use App\Templates\CreatePage;
use App\Templates\DeletePage;
use App\Templates\EditPage;
use App\Templates\ErrorPage;
use App\Templates\NotFoundPage;
use App\Templates\PostPage;

session_start();

require 'vendor/autoload.php';

$page = '';

try {
    Auth::checkAuthenticated();

    $request = new Request();
    switch ($request->get('action')) {
        case 'posts':
            $page = new PostPage();
            break;
        case 'create':
            $page = new CreatePage();
            break;
        case 'edit':
            $page = new EditPage();
            break;
        case 'delete':
            $page = new DeletePage();
            break;
        case 'logout':
            Auth::logoutUser();
            break;
        default:
            throw new NotFoundException('Not Found Page!');
    }
} catch (DoesNotExistsException | NotFoundException $exception) {
    $page = new NotFoundPage($exception->getMessage());
} catch (Exception $exception) {
    $page = new ErrorPage($exception->getMessage());
} finally {
    $page->renderPage();
}