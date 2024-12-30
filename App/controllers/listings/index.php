
<?php
    use FrameWork\Connection;
    $config=require (base_path("config/dbconnect.php"));
    $connection=new Connection($config);
    $listings=$connection->query("SELECT * FROM listings")->fetchAll();
    loadView("listings/index",["listings"=>$listings]);
?>

