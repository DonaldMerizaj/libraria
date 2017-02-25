<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\AutoriClass;
use App\Http\Controllers\Classes\InventarClass;
use App\Http\Controllers\Classes\LibriClass;
use App\Http\Controllers\Classes\ZhanriClass;
use App\Models\LibriModel;
use Illuminate\Http\Request;

class LibriController extends Controller
{
    public function index(){
        $librat = LibriModel::select(LibriClass::TABLE_NAME.'.'.LibriClass::TITULLI,LibriClass::TABLE_NAME.'.'.LibriClass::ID,
                    LibriClass::TABLE_NAME.'.'.LibriClass::CMIMI, LibriClass::TABLE_NAME.'.'.LibriClass::SHTEPI_BOTUESE,
                    LibriClass::TABLE_NAME.'.'.LibriClass::VITI, AutoriClass::TABLE_NAME.'.'.AutoriClass::EMRI,
                    AutoriClass::TABLE_NAME.'.'.AutoriClass::MBIEMRI, InventarClass::TABLE_NAME.'.'.InventarClass::GJENDJE)
                    ->join(AutoriClass::TABLE_NAME, AutoriClass::ID, LibriClass::TABLE_NAME.'.'.LibriClass::ID_AUTOR)
                    ->join(InventarClass::TABLE_NAME, InventarClass::ID_LIBRI, LibriClass::TABLE_NAME.'.'.LibriClass::ID)
                    ->get();

        return view('backend.librat')
            ->with('librat', $librat);
    }

    public function edito($id){
        if (isset($id) && is_numeric($id)){
            //TODO:edit libri
//            $libri =
        }else{
            abort(404);
        }
    }
}
