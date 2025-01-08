<?php
    namespace App\Controllers;
    use FrameWork\Connection;
    use FrameWork\Validation;
    use FrameWork\Session;

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
                    $query = "INSERT INTO users (name, email, password, city, state) VALUES (:name, :email, :password, :city, :state)";
                    $res=$this->db->query($query, $user);
                    if($res) {

                        $userid=$this->db->query("select id from users where email=:email;",["email"=>$email])->fetch()["id"];
                        Session::set("user",[
                            "user_id"=>$userid,
                            "name"=>$user["name"],
                            "email"=>$user["email"],
                            "city"=>$user["city"],
                            "state"=>$user["state"]
                        ]);


                        redirect("/auth/login");
                    }
                    else {
                        inspect("Error creating user");
                    }
                }
            }
        }

        public function logout(){
            Session::destroy();
            $param=session_get_cookie_params();
            setcookie("PHPSESSID","",time()-86400,$param["path"],$param["domain"]);
            redirect("/auth/login");
        }


        public function authenticate(){
            $email=$_POST["email"];
            $password=$_POST["password"];
            $errors=[];
            if(!Validation::email($email)){
                $errors["email"]="Email Not Valid";
            }
            if(!Validation::string($password,6,50)){
                $errors["password"]="Password not Valid";
            }
            if(!empty($errors)){
                loadView("/login",["errors"=>$errors]);
                exit();
            }
            $param=[
                "email"=>$email
            ];
            $query='select * from users where email= :email';
            $res=$this->db->query($query,$param)->fetch();
            if(!$res){
                $errors["email"]="Email not found";
                loadView("/login",["errors"=>$errors]);
                exit();
            }
            else {
                if(password_verify($password,$res["password"])){
                    Session::set("user",[
                        "user_id"=>$res["id"],
                        "name"=>$res["name"],
                        "email"=>$res["email"],
                        "city"=>$res["city"],
                        "state"=>$res["state"]
                    ]);
                    redirect("/");
                }
                else{
                    $errors["password"]="Incorrect Password";
                    loadView("/login",["errors"=>$errors]);
                    exit();
                }
            }
        }
    }
?>