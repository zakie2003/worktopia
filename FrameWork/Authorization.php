<?php

namespace FrameWork;
use FrameWork\Session;

class Authorization{
    public static function isOwner($role){
        $user=Session::get("user");
        if($user!=null && isset($user["user_id"])){
            $sessionUserId=(int)$user["user_id"];
            return $sessionUserId==$role;
        }
        return false;
    }
}

?>