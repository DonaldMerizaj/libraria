<?php

namespace App\Http\Controllers;

use App\Http\Classes\AutoriClass;
use App\Http\Classes\LibriClass;
use App\Http\Classes\ZhanriClass;
use App\Models\LibriModel;
use Illuminate\Http\Request;

class LibriController extends Controller
{
    public function index(){
        $librat = LibriModel::select(LibriClass::TABLE_NAME.'.'.LibriClass::TITULLI, LibriClass::CMIMI,
                    LibriClass::SHTEPI_BOTUESE,LibriClass::VITI, LibriClass::DESC, LibriClass::TABLE_NAME.'.'.LibriClass::IMAGE,
                    ZhanriClass::TABLE_NAME.'.'.ZhanriClass::EMRI, AutoriClass::TABLE_NAME.'.'.AutoriClass::EMRI)
                    ->join(AutoriClass::TABLE_NAME, AutoriClass::ID, LibriClass::TABLE_NAME.'.'.LibriClass::ID_AUTOR)
                    ->join(ZhanriClass::TABLE_NAME, ZhanriClass::ID, LibriClass::TABLE_NAME.'.'.LibriClass::ID_ZHANRI)
                    ->get();

        return view('backend.librat')
            ->with('librat', $librat);
    }
}
