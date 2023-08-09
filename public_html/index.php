<?php

require 'controllers/controllers.php';

$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);
$defaultController = 'getStaticPage';

const CONTROLLERS_PATH = [
    "/" => "getHome",
    "/login/submit" => "getLoginSubmitPage",
    "/signup/submit" => "getSignupSubmitPage",
];

$controller = CONTROLLERS_PATH[$path];

if ($controller && function_exists("$controller")) {
    echo $controller($path);
} else {
    echo $defaultController($path);
}

?>
