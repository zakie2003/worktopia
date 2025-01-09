<?php
    namespace FrameWork\Middleware;
    use FrameWork\Session;

    class Authorize{

        /**
         * @return bool
         */

         public function isAuthenticated(){
             return Session::check("user");
         }

        /** handle user request 
         * @param $role
         * @return bool
         */

         public function handle($role){
            if($role=="guest" && $this->isAuthenticated()){
                return redirect("/");
            }
            elseif($role=="auth" && !$this->isAuthenticated()){
                return redirect("/auth/login");
            }
         }

    }
?>