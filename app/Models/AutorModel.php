<?php

namespace App\Models;

use App\Http\Controllers\Classes\AutoriClass;
use Illuminate\Database\Eloquent\Model;

class AutorModel extends Model
{
    protected $table = AutoriClass::TABLE_NAME;
    protected $primaryKey = AutoriClass::ID;
    public $timestamps = false;
}
