<?php

use JetBrains\PhpStorm\NoReturn;

const BASE_URL = 'http://localhost:8080/';

#[NoReturn]
function dd($data): void
{
    die('<pre>' . print_r($data, true) . '</pre>');
}

function asset($file): string
{
    return BASE_URL . 'assets/' . $file;
}

function url($path, $query = []): string
{
    if (!count($query)) {
        return BASE_URL . $path;
    }

    return BASE_URL . $path . '?' . http_build_query($query);
}