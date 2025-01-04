<?php
/**
 * @param string $path 
 * @return string  
 */

 function base_path($path=''){
    if(file_exists(__DIR__ . "/" . $path)){
        return __DIR__ . "/" . $path;
    }
    else{
        echo "File not found in " . __DIR__ . "/" . $path;
    }
 }


 function loadComponent($name,$data=[]){
    if(!file_exists(base_path("App/views/components/$name.php"))){
        echo "File not found in " . base_path("views/components/$name.php");
    }
    else{
        extract($data);
        require base_path("App/views/components/$name.php");
    }
 }

 function loadView($name,$data=[]){
    if(!file_exists(base_path("App/views/$name.php"))){
        echo "File not found in " . base_path("views/$name.php");
    }
    else{
        extract($data);
        require base_path("App/views/$name.php");
    }
 }

/**
 * @param string $name
 * @return void
 */
 function inspect($val){
    echo "<pre>";
        var_dump($val);
    echo "</pre>";
 }

 function delete_inspect($val){
    echo "<pre>";
        var_dump($val);
    echo "</pre>";
    die();
 }

 function sanitize($dirty){
    return filter_var(trim($dirty),FILTER_SANITIZE_SPECIAL_CHARS);
 }

?>