<?php
/**
 * Created by PhpStorm.
 * User: Megli
 * Date: 2/8/2017
 * Time: 9:47 PM
 */

namespace App\Http\Controllers\Classes;


class LoginClass
{
    const TABLE_NAME = 'login';
    const ID = 'login_id';
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const ROLE = 'role';

    const ADMIN = 1;
    const PUNONJES = 2;
    const KLIENT = 3;
}