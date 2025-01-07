<?php
    namespace App\Controllers;
    use FrameWork\Connection;
    use FrameWork\Validation;

    class UserController{
        public $db;

        public function __construct(){
            $config=require base_path("config/dbconnect.php");
            $this->db=new Connection($config);
        }

        /**
         * @return void
         */
        public function login(){
            loadView("login");
        }

        /**
         * @return void
         */
        public function create(){
            loadView("register");
        }

        public function store(){
            $name=$_POST["name"];
            $email=$_POST["email"];
            $password=$_POST["password"];
            $city=$_POST["city"];
            $state=$_POST["state"];
            $confirm_password=$_POST["password_confirmation"];
            $errors=[];

            if(!Validation::email($email)){
                $errors["email"]="Email is not valid";
            }
            if(!Validation::string($name,2,50)){
                $errors["name"]="Name is not valid";
            }
            if(!Validation::string($password,6,50)){
                $errors["password"]="Password is not valid";
            }
            if(!Validation::match($password,$confirm_password)){
                $errors["password_confirmation"]="Password does not match";
            }

            $user=[
                "name"=>$name,
                "email"=>$email,
                "password"=>password_hash($password,PASSWORD_BCRYPT),
                "city"=>$city,
                "state"=>$state
            ];

            if(!empty($errors)) {
                loadView("/register",["errors"=>$errors,"newListing"=>$user]);
            } else {
                $param=["email"=>$email];
                $res=$this->db->query("select * from users where email=:email;", $param)->fetch();
                if(!empty($res)){
                    $errors["email"]="Email already exists";
                    loadView("/register",["errors"=>$errors,"newListing"=>$user]);
                } else {
                    inspect($user);
                    $query = "INSERT INTO users (name, email, password, city, state) VALUES (:name, :email, :password, :city, :state)";
                    $res=$this->db->query($query, $user);
                    if($res) {
                        redirect("/auth/login");
                    }
                    else {
                        inspect("Error creating user");
                    }
                }
            }
        }
    }
?>