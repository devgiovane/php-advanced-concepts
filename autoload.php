<?php

spl_autoload_register(function (string $nameClass) {
    $path = str_replace('Study', 'src', $nameClass);
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
    $path .= '.php';

    if(file_exists($path)) {
        /** @noinspection PhpIncludeInspection */
        require_once $path;
    }
});