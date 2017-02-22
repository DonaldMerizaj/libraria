<?php

namespace App\Models;

use App\Http\Controllers\Classes\LibriClass;
use Illuminate\Database\Eloquent\Model;

class LibriModel extends Model
{
    protected $table = LibriClass::TABLE_NAME;
    protected $primaryKey = LibriClass::ID;
}
