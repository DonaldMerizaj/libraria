<?php

namespace App\Models;

use App\Http\Controllers\Classes\LibriToZhanriClass;
use Illuminate\Database\Eloquent\Model;

class LibriToZhanriModel extends Model
{
    protected $table = LibriToZhanriClass::TABLE_NAME;
    protected $primaryKey = LibriToZhanriClass::ID;
    public $timestamps = false;
}
