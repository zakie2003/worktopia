<?php
    namespace App\Controllers;
    use FrameWork\Connection;
    use FrameWork\Validation;
    use FrameWork\Session;
    use FrameWork\Authorization;

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
            $listings=$this->db->query("select * from listings order by created_at desc limit 2;")->fetchAll();
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
            $listings=$this->db->query("select * from listings order by created_at desc;")->fetchAll();
            // inspect($listing);
            loadView("listings/index",["listings"=>$listings]);
        }

        public function store(){
            $allowed=["title","description","salary","requirements","benefits","company","tags","city","state","address","phone","email"];
            
            $newListing=array_intersect_key($_POST,array_flip($allowed));
            $newListing=array_map("sanitize",$newListing);
            $newListing["user_id"]=Session::get("user")["user_id"];
            // inspect($newListing);
            $required_field=["title","description","city","state","email","salary"];
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
                $values=[];
                foreach($newListing as $field=>$value){
                    $fields[]=$field;
                    if($value==""){
                        $values[]=null;
                    }
                    else{
                        $values[]=":" .$field;
                    }
                }

                $fields=implode(",",$fields);
                $values=implode(",",$values);
                $query="insert into listings($fields) values($values);";
                // inspect($query);
                $this->db->query($query,$newListing);
                redirect("/listing");
            }
        }


        public function destroy($param){
            $id = $param["id"];
            $params = ["id" => $id];
            $res = $this->db->query("select * from listings where id=:id;", $params)->fetch();
            if (!$res) {
                ErrorController::NotFound("Listing not found", 404);
                exit();
            } else {
                if (!Authorization::isOwner($res["user_id"])) {
                    Session::setflash("error_message", "You are not authorized to delete this listing");
                    return redirect("/listing/show/$id");
                }
                $this->db->query("delete from listings where id=:id;", $params);
                Session::setflash("success_message", "Listing deleted successfully");
                redirect("/listing");
            }
        }

        public function edit($param){
            $id=$param["id"];
            $params=["id"=>$id];
            $res=$this->db->query("select * from listings where id =:id",$params)->fetch();
            if(!$res){
                ErrorController::NotFound("Listing not found",404);
                exit();
            }
            else{
                if(!Authorization::isOwner($res["user_id"])){
                    Session::setflash("error_message","You are not authorized to update this listing");
                    return redirect("/listing/show/$id");
                }
                loadView("/listings/edit",["newListing"=>$res]);
            }
        }


        public function update($param){
            $id=$param["id"];
            $params=["id"=>$id];
            $res=$this->db->query("select * from listings where id =:id",$params)->fetch();
            if(!$res){
                ErrorController::NotFound("Listing not found",404);
                exit();
            }
            else{
                if(!Authorization::isOwner($res["user_id"])){
                    Session::setflash("error_message","You are not authorized to update this listing");
                    return redirect("/listing/show/$id");
                }
                // inspect($res);
                $allowed=["title","description","salary","requirements","benefits","company","tags","city","state","address","phone","email"];
                $updated_values=[];
                $updated_values=array_intersect_key($_POST,array_flip($allowed));
                $updated_values=array_map("sanitize",$updated_values);
                $required_field=["title","description","city","state","email","salary"];
                $errors=[];
                foreach($required_field as $field){
                    if(empty($updated_values[$field])|| !Validation::string($updated_values[$field])){
                        $errors[$field]= "This $field is required";
                    }
                }
                // inspect($errors);
                if(!empty($errors)){

                    loadView("listings/edit",["errors"=>$errors,"newListing"=>$res]);
                    exit();
                }
                else{
                    $updated_field=[];
                    foreach (array_keys($updated_values) as $key) {
                        
                        $updated_field[]="$key = :$key";

                    }
                    // inspect($updated_field);
                    $updated_field=implode(", ",$updated_field);
                    // inspect($updated_field);
                    $query="update listings set $updated_field where id=:id;";
                    $this->db->query($query,array_merge($updated_values,$params));
                    // inspect(array_merge($updated_values,$params));
                    Session::setflash("success_message","Listing updated successfully");
                    redirect("/listing/show/$id");
                }
            }
        }


/**
 * This method handles search functionality for listings.
 *
 * @param array $param The parameters for search, including potential filters like keywords and location.
 * @return void
 */

        public function search($param){
            $keyword=isset($_GET["keywords"])?trim($_GET["keywords"]):"";
            $location=isset($_GET["location"])?trim($_GET["location"]):"";
            $listings=$this->db->query("select * from listings where title like :keyword or description like :keyword or company like :keyword or tags like :keyword and (city like :location or state like :location);",["keyword"=>"%$keyword%","location"=>"%$location%"])->fetchAll();
            loadView("listings/index",["listings"=>$listings]);
        }
    }
?>