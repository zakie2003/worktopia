<?php

namespace App\Controllers;
class ErrorController{

    public static function NotFound($message="Page not found",$code=404){
        http_response_code($code);
        loadView("error.view",["message"=>$message,"code"=>$code]);
    }

    public static function UnAutorized($message="User UnAutorized",$code=401){
        http_response_code($code);
        loadView("error.view",["message"=>$message,"code"=>$code]);
    }
}
?>