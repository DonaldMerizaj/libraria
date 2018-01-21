<?php

namespace App\Models;

use App\Http\Controllers\Classes\ZhanriClass;
use Illuminate\Database\Eloquent\Model;

class ZhanriModel extends Model
{
    protected $table = ZhanriClass::TABLE_NAME;
    protected $primaryKey = ZhanriClass::ID;
    public $timestamps = false;
}
