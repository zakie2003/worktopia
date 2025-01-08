<?php

    namespace FrameWork;

    class Session{

    /**
         * Start the session if it hasn't been started yet.
         *
         * @return void
         */
        public static function start(){
            if(session_status()==PHP_SESSION_NONE){
                session_start();
            }
        }
    /**
     * Set a session variable.
     *
     * @param string $key The key to identify the session variable.
     * @param mixed $value The value to be stored in the session variable.
     *
     * @return void
     */

        public static function set($key,$value){
            $_SESSION[$key]=$value;
        }

    /**
     * Retrieve a session variable by key.
     *
     * @param string $key The key to identify the session variable.
     * @return mixed The value stored in the session variable.
     */

        public static function get($key,$default=null){
           if(self::check($key)){
            return $_SESSION[$key];
           }
           return $default;
        }


        public static function check($key){
            if(isset($_SESSION[$key])){
                return true;
            }
            return false;
        }


        public static function unset($key){
            if(isset($_SESSION[$key])){
                unset($_SESSION[$key]);
            }
        }


        public static function destroy(){
            if(session_status()==PHP_SESSION_ACTIVE){
                session_unset();
                session_destroy();
            }
        }

    }
 ?>