<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AutorController extends Controller
{
    public function categories(){
        return view('backend.categories');
    }
}
