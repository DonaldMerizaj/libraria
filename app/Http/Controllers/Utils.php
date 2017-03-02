<?php
/**
 * Created by PhpStorm.
 * User: Megli
 * Date: 2/8/2017
 * Time: 9:59 PM
 */

namespace App\Http\Controllers;


use App\Http\Controllers\Classes\KlientClass;
use App\Http\Controllers\Classes\LoginClass;
use App\Http\Controllers\Classes\UserClass;
use App\Models\KlientModel;
use App\Models\LoginModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class Utils
{
    const SESSION_USER_ID = 'user_id';
    const SESSION_ROLE = 'role';
    const PATH = '/img/';

    public static function setLogin($user_id, $role)
    {
        Session::set(self::SESSION_USER_ID,$user_id );
        Session::set(self::SESSION_ROLE, $role);
        Session::save();
    }

    public static function getUsername(){
        return LoginModel::where(LoginClass::TABLE_NAME.'.'.LoginClass::ID, Utils::getLoginId())->first()->username;
    }
public static function getUserId(){
        return UserModel::where(UserClass::TABLE_NAME.'.'.UserClass::ID_LOGIN, Utils::getLoginId())->first()->user_id;
    }

    public static function getKlientId(){
//echo         Utils::getLoginId();die();
        return KlientModel::where(KlientClass::TABLE_NAME.'.'.KlientClass::LOGIN, Utils::getLoginId())->first()->klient_id;

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

    public static function getLoginId()
    {
        return Session::get(self::SESSION_USER_ID);
    }

    public static function ruajFoto($name){
        $filename ='';
        if(Input::file($name))
        {
            $image = Input::file($name);
            $filename  = str_replace(".","",microtime(true)) . '.' . $image->getClientOriginalExtension();
            Input::file($name)->move(Utils::PATH, $filename);
        }
        return $filename;

    }
}