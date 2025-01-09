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



        /**
         * Check if a session variable exists.
         *
         * @param string $key The key to check.
         * @return boolean True if the session variable exists, false otherwise.
         */
        public static function check($key){
            if(isset($_SESSION[$key])){
                return true;
            }
            return false;
        }


    /**
     * Unset a session variable by key.
     * @param string $key The key to identify the session variable to be removed.
     * @return void
     */


        public static function unset($key){
            if(isset($_SESSION[$key])){
                unset($_SESSION[$key]);
            }
        }



        /**
         * Destroy the session, removing all session variables and session data.
         *
         * This method will only destroy the session if it is currently active.
         *
         * @return void
         */
        public static function destroy(){
            if(session_status()==PHP_SESSION_ACTIVE){
                session_unset();
                session_destroy();
            }
        }

        /**
         * Flash a message to be displayed on the next request.
         *
         * @param string $key The key to identify the flash message.
         * @param string $message The message to be displayed.
         * @return void
         */

        public static function setflash($key,$message=""){
            self::set("flash_".$key,$message);
        }

        /**
         * Get a flash message by key.
         *
         * @param string $key The key to identify the flash message.
         * @return string The message stored in the flash message.
         */

         public static function getFlash($key,$default=null){
            $msg=self::get("flash_".$key,$default);
            self::unset("flash_".$key);
            return $msg;
         }


    }
 ?>