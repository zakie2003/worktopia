<?php
    namespace App\Controllers;
    use FrameWork\Connection;
    use FrameWork\Validation;

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

        
        /**
         * This function is used to show all the listings on the index page
         * @return void
         */
        public function lisiting(){
            $listings=$this->db->query("select * from listings;")->fetchAll();
            // inspect($listing);
            loadView("listings/index",["listings"=>$listings]);
        }

        public function store(){
            $allowed=["title","description","salary","requirements","benefits","company","tags","city","state","address","phone","email"];
            
            $newListing=array_intersect_key($_POST,array_flip($allowed));
            $newListing=array_map("sanitize",$newListing);
            $newListing["user_id"]=1;
            // inspect($newListing);
            $required_field=["title","description","city","state","email"];
            $errors=[];
            foreach ($required_field as $field) {
                if(empty($newListing[$field]) || !Validation::string($newListing[$field])){
                    $errors[$field]= "This $field is required";
                    // inspect($newListing[$field]);
                }
            }
            if(!empty($errors)){
                // inspect($newListing);
                loadView("listings/create",["errors"=>$errors,"newListing"=>$newListing]);
            }
            else{
                $fields=[];
                foreach($newListing as $key=>$value){
                    $fields
            }
        }
    }
?>