<?php

namespace App\Http\Controllers;

use App\Http\Classes\LoginClass;
use App\Models\KlientModel;
use App\Models\LoginModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login(Request $request){
        $this->validate($request, [
            'username'=>'required',
            'password'=>'required'
        ]);
        $pass=Utils::enkripto($request->password);
//        echo $pass;die();
        $user=LoginModel::where('username',$request->username)->where('password',$pass)
            ->first();
        if(count($user) > 0) {
            $role = $user->role;
            if ($role == LoginClass::KLIENT) {
                $useri = KlientModel::where('id_login', $user->login_id)->first();
            } else {
                $useri = UserModel::where('id_login', $user->login_id)->first();
            }
            Utils::setLogin($user->login_id, $role);
            return Redirect::route('dashboard');
        }
           else{
            return Redirect::back()->withErrors('Të dhënat nuk u gjetën, ju lutemi vendosni të dhënat e sakta!');
        }
    }

    public function index(){
        return view('backend.home');
    }

    public function pass(){
        echo Utils::enkripto('123456');
    }

    public function logout(){
        Session::forget(Utils::SESSION_USER_ID );
        Session::forget(Utils::SESSION_ROLE);

        return Redirect::route('loginView');

    }
}
