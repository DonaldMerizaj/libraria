<?php

namespace App\Models;

use App\Http\Controllers\Classes\HuazimClass;
use Illuminate\Database\Eloquent\Model;

class HuazimModel extends Model
{
    protected $table = HuazimClass::TABLE_NAME;
    protected $primaryKey = HuazimClass::ID;
    public $timestamps = false;
}
