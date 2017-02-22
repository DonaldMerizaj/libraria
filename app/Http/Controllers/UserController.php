<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\LoginClass;
use App\Http\Controllers\Classes\UserClass;
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

    public function listoPunonjes(){
        $punonjes = UserModel::select(UserClass::TABLE_NAME.'.'.UserClass::EMRI, UserClass::TABLE_NAME.'.'.UserClass::MBIEMRI,
            UserClass::TABLE_NAME.'.'.UserClass::EMAIL)
            ->join(LoginClass::TABLE_NAME, LoginClass::TABLE_NAME.'.'.LoginClass::ID, UserClass::TABLE_NAME.'.'.UserClass::ID_LOGIN)
            ->where(LoginClass::TABLE_NAME.'.'.LoginClass::ROLE, LoginClass::PUNONJES)
            ->get();
        if ($punonjes) {
            return view('backend.users')
                ->with('users', $punonjes);
        }else{
            return Redirect::back();
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
