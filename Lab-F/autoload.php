<?php

spl_autoload_register(function ($class) {
    // Definiujemy bazowy katalog dla naszych klas
    $baseDir = __DIR__ . '/lib/';

    // Jeśli klasa to Serializer, plik jest bezpośrednio w lib/
    if ($class === 'Serializer') {
        $file = $baseDir . 'Serializer.php';
    }
    // Jeśli nazwa klasy kończy się na 'Encoder' lub 'Interface',
    // szukamy jej w podfolderze lib/Encoder/
    else {
        $file = $baseDir . 'Encoder/' . $class . '.php';
    }

    if (file_exists($file)) {
        require_once $file;
    }
});