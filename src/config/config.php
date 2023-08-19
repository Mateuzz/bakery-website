<?php

$gDatabaseOptions = [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '123',
];

enum Modes {
    case Development;
    case Production;
}

$gMode = Modes::Production;

define('UPLOADED_IMAGES_FULL_PATH', $_SERVER['DOCUMENT_ROOT'] . '/images/products');
define('UPLOADED_IMAGES_PATH', '/images/products');

?>
