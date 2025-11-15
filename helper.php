<?php

function dd($data): void
{
    die('<pre>' . print_r($data, true) . '</pre>');
}