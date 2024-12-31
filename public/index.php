<?php

require __DIR__ . "/../vendor/autoload.php";
require "../helpers.php";

use FrameWork\Router;

$url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];

$router = new Router();

// Load routes from a separate file
require base_path("routes.php");

// Dispatch the request
$router->dispatch($url);

?>