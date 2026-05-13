<?php

spl_autoload_register(function ($class) {

    $baseDir = __DIR__ . '/lib/';

    if ($class === 'Serializer') {
        $file = $baseDir . 'Serializer.php';
    }

    else {
        $file = $baseDir . 'Encoder/' . $class . '.php';
    }

    if (file_exists($file)) {
        require_once $file;
    }
});