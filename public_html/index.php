<?php

    ini_set("display_errors", true);
    error_reporting(E_ALL);

require 'controllers/controllers.php';

$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);

const CONTROLLERS_PATH = [
    "/" => "homePage",
    "/about" => "aboutPage",
    "/menu" => "menuPage",
    "/cart" => "cartPage",
    "/contact" => "contactPage",
    "/user/login" => "loginPage",
    "/user/logged" => "loggedPage",
    "/user/logout" => "logoutPage",
    "/user/signup" => "signupPage",
    "/admin/stock" => "stockControlPage",
];


if (isset(CONTROLLERS_PATH[$path])) {
    session_start();
    $controller = CONTROLLERS_PATH[$path];
    echo $controller($path);
} else {
    http_response_code(404);
}

?>
