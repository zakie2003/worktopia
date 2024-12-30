<?php

    require __DIR__."/../vendor/autoload.php";

    require "../helpers.php";
    
    use FrameWork\Router;

    // spl_autoload_register(function($class){
    //     $path="FrameWork/".$class.".php";
    //     if(file_exists(base_path($path))){
    //         require base_path($path);
    //     } 
    // });
    
    $url=parse_url($_SERVER["REQUEST_URI"],PHP_URL_PATH);
    $method=$_SERVER["REQUEST_METHOD"];


    $router=new Router();

    $route=require base_path("routes.php");
    $router->routes($method,$url);

?>