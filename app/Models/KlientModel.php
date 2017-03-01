<?php

namespace App\Models;

use App\Http\Controllers\Classes\KlientClass;
use Illuminate\Database\Eloquent\Model;

class KlientModel extends Model
{
    protected $table = KlientClass::TABLE_NAME;
    protected $primaryKey = KlientClass::ID;
    public $timestamps = true;
}
