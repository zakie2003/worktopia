<?php
    use FrameWork\Connection;

    // require "../helpers.php";
    $config=require base_path("config/dbconnect.php");
    $db=new Connection($config);
    $listings=$db->query("select * from listings;")->fetchAll();
    // inspect($listing);
    loadView("home",["listings"=>$listings]);
?>
