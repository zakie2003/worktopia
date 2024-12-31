<?php
    namespace App\Controllers;
    use FrameWork\Connection;

    class HomeController{
        public $db;
        /**
         * This is the constructor of the class, it will be called automatically once the object of the class is created.
         * @return void
         */
        public function __construct(){
            $config=require base_path("config/dbconnect.php");
            $this->db=new Connection($config);
        }

        /**
         * @return void
         */
        public function index(){
            $listings=$this->db->query("select * from listings;")->fetchAll();
            // inspect($listing);
            loadView("home",["listings"=>$listings]);
        }


        /**
         * @return void
         */

        public function create(){
            loadView("listings/create");
        }

        /**
         * @return void
         */
        public function show($param){
            $id=$param["id"] ?? "";
            $listing=$this->db->query("select * from listings where id=$id;")->fetch();
            loadView("listings/show",["listing"=>$listing]);
        }

        
        public function lisiting(){
            $listings=$this->db->query("select * from listings;")->fetchAll();
            // inspect($listing);
            loadView("listings/index",["listings"=>$listings]);
        }
    }
?>