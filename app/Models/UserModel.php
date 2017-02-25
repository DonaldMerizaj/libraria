<?php

namespace App\Models;

use App\Http\Controllers\Classes\UserClass;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = UserClass::TABLE_NAME;
    protected $primaryKey = UserClass::ID;
}
