<?php

namespace App\Models;

use App\Http\Controllers\Classes\InventarClass;
use Illuminate\Database\Eloquent\Model;

class InventarModel extends Model
{
    protected $table = InventarClass::TABLE_NAME;
    protected $primaryKey = InventarClass::ID;
    public $timestamps = false;
}
