<?php

    class Connection{
        public $db;
        public $options=[];

        /**
         * @var $connection
         */

        function __construct($config){
            $dns="mysql:host={$config["host"]};dbname={$config["dbname"]};charset={$config["charset"]}";
            $username=$config['username'];
            $password=$config['password'];
            $options=[
                PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
            ];
            try{
                $this->db = new PDO($dns,$username,$password,$options);
             }
             catch(PDOException $e){
                echo "Connection failed: " . $e->getMessage();
             }
        }


        function query($stmt){
            try{
                $res=$this->db->prepare($stmt);
                $res->execute();
                return $res;

            }
            catch(PDOException $e){
                echo "Connection failed: " . $e->getMessage();
            }
        }
    }
?>