<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\HuazimClass;
use App\Http\Controllers\Classes\InventarClass;
use App\Http\Controllers\Classes\LibriClass;
use App\Models\HuazimModel;
use App\Models\InventarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class InventarController extends Controller
{
    public function raporte(){
        try{
            //libri me i kerkuar sipas zhanerit
//            $libri = DB::select('')

            //gjendja e librave ne inventar
            $inv = InventarModel::select(InventarClass::TABLE_NAME.'.'.InventarClass::GJENDJE, LibriClass::TABLE_NAME.'.'.LibriClass::TITULLI)
                ->join(LibriClass::TABLE_NAME, LibriClass::TABLE_NAME.'.'.LibriClass::ID, InventarClass::ID_LIBRI)
                ->get();

            //librat e huazuar
            $huazim = HuazimModel::where(HuazimClass::TABLE_NAME.'.'.HuazimClass::KTHYER, HuazimClass::I_PAKTHYER)
                ->get();
            //kane kaluar afatin
            $jashteAfati = HuazimModel::where(HuazimClass::TABLE_NAME.'.'.HuazimClass::KTHYER, HuazimClass::I_PAKTHYER)
                ->where(HuazimClass::TABLE_NAME.'.'.HuazimClass::DATA_DOREZIMIT, '<', date('Y-m-d'))
                ->get();

            echo count($huazim).': jshAfati|'.count($huazim);die();
        }catch(\Exception $e){
            return Redirect::back()->withErrors($e->getMessage());
        }
    }
}
