<?php

namespace App\Models;

use App\Http\Controllers\Classes\LoginClass;
use Illuminate\Database\Eloquent\Model;

class LoginModel extends Model
{
    protected $table = LoginClass::TABLE_NAME;
    protected $primaryKey = LoginClass::ID;
}
