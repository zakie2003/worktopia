<?php

    $router->get("/","controllers/home.php");
    $router->get("/listing","controllers/listings/index.php");
    $router->get("/listing/create","controllers/listings/create.php");

?>