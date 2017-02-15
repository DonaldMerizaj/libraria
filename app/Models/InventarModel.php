<?php

namespace App\Models;

use App\Http\Classes\InventarClass;
use Illuminate\Database\Eloquent\Model;

class InventarModel extends Model
{
    protected $table = InventarClass::TABLE_NAME;
    protected $primaryKey = InventarClass::ID;
}
