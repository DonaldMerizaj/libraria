<?php
/**
 * Created by PhpStorm.
 * User: Megli
 * Date: 2/8/2017
 * Time: 9:59 PM
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Session;

class Utils
{
    const SESSION_USER_ID = 'user_id';
    const SESSION_ROLE = 'role';


    public static function setLogin($user_id, $role)
    {
        Session::set(self::SESSION_USER_ID,$user_id );
        Session::set(self::SESSION_ROLE, $role);
        Session::save();
    }

    public static function isLogged() {
        if (Session::has(self::SESSION_USER_ID)){
            return true;
        }else{
            return false;
        }
    }

    public static function enkripto($password){
        return md5(base64_encode($password));
    }

    public static function getRole()
    {
        return Session::get(self::SESSION_ROLE);
    }

    public static function getUserId()
    {
        return Session::get(self::SESSION_USER_ID);
    }
}