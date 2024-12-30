<?php
    use FrameWork\Connection;
    $config=require (base_path("config/dbconnect.php"));
    $connection=new Connection($config);
    $id=$_GET["id"] ?? "";
    $listing=$connection->query("SELECT * FROM listings WHERE id=".$id)->fetch();
   loadView("listings/show",["listing"=>$listing]);
?>