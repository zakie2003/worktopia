<?php
    namespace FrameWork;
    class Validation{
        /**
         * Validate a string.
         *
         * @param string $value The value to check.
         * @param int $min The minimum length.
         * @param int $max The maximum length.
         *
         * @return bool True if the string is valid, false otherwise.
         */
        public static function string($value,$min=1,$max=INF){
            if(is_string($value)){
                $value=trim($value);
                return strlen($value)>=$min && strlen($value)<=$max;
            }
            return false;
        }

        /**
         * Validate an email address.
         *
         * @param string $value The value to check.
         *
         * @return bool True if the email is valid, false otherwise.
         */
        public static function email($value){
            $value=trim($value);

            return filter_var($value,FILTER_VALIDATE_EMAIL);
        }

        /**
         * Match function
         */

         public static function match($value1,$value2){
            $value1=trim($value1);
            $value2=trim($value2);
            return $value1==$value2;
         }
    }
?>