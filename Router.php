<?php

class Router{
    protected $routes=[];

    /** 
    * @method string $method
    * @param string $url
    * @return string $controller
    */
    public function get_method($method,$url,$controller){
        $this->routes[]=[
           "method"=>$method,
           "url"=>$url,
           "controller"=>$controller];
   }

    /**
     * @method string get
     * @param string $url
     * @return string $controller
     */
    public function get($url,$controller){
         $this->get_method("GET",$url,$controller);
    }
    /**
     * @method string post
     * @param string $url
     * @return string $controller
     */

    public function post($url,$controller){
         $this->get_method("POST",$url,$controller);
    }

    /**
     * @method string put
     * @param string $url
     * @return string $controller
     */

    public function put($url,$controller){
         $this->get_method("PUT",$url,$controller);
    }


    /**
     * @method string delete
     * @param string $url
     * @return string $controller
     */

     public function delete($url,$controller){
        $this->get_method("DELETE",$url,$controller);
   }


   
    /**
     * Returns all the routes registered
     * 
     * @return array
     */
   public function routes($method,$url){
       foreach($this->routes as $route){
           if($route["method"]==$method && $route["url"]==$url){
               require(base_path($route["controller"]));
               return;
           }
       }

       http_response_code(404);
       loadView("error/404");
       exit;
   }


}

?>