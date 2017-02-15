<?php

namespace App\Models;

use App\Http\Classes\KlientClass;
use Illuminate\Database\Eloquent\Model;

class KlientModel extends Model
{
    protected $table = KlientClass::TABLE_NAME;
    protected $primaryKey = KlientClass::ID;
}
