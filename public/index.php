<?php
    require "../helpers.php";



    $url=$_SERVER["REQUEST_URI"];
    $method=$_SERVER["REQUEST_METHOD"];

    require base_path("Router.php");

    $router=new Router();

    $route=require base_path("routes.php");

    $router->routes($method,$url);

?>