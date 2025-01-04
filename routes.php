<?php
    $router->get("/","HomeController@index");
    $router->get("/listing","HomeController@lisiting");
    $router->get("/listing/create","HomeController@create");
    $router->get("/listing/show/{id}","HomeController@show");
    
    $router->post("/listing","HomeController@store");
?>