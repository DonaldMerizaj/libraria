<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\AutoriClass;
use App\Http\Controllers\Classes\HuazimClass;
use App\Http\Controllers\Classes\KlientClass;
use App\Http\Controllers\Classes\LibriClass;
use App\Models\HuazimModel;
use App\Models\KlientModel;
use App\Models\LibriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class KlientController extends Controller
{
    public function index(){
        $klient = KlientModel::select(KlientClass::TABLE_NAME.'.'.KlientClass::ID,KlientClass::TABLE_NAME.'.'.KlientClass::EMRI,
            KlientClass::TABLE_NAME.'.'.KlientClass::MBIEMRI, KlientClass::TABLE_NAME.'.'.KlientClass::EMAIL,
            KlientClass::TABLE_NAME.'.'.KlientClass::CEL )
            ->get();

        return view('backend.klient.index')
            ->with('klient', $klient)
            ;
    }

    public function create(){
        return view('backend.klient.create');
    }

    public function ruaj(Request $request){

        try{
            DB::beginTransaction();

            $emri = htmlentities(trim($request->emri));
            $mbiemri = htmlentities(trim($request->mbiemri));
            $email = htmlentities(trim($request->email));
            $cel = htmlentities(trim($request->cel));

            $new = new KlientModel();
            $new->emri = $emri;
            $new->mbiemri = $mbiemri;
            $new->email = $email;
            $new->cel = $cel;
            $new->id_login = 3;
            $new->save();

            DB::commit();
            return Redirect::route('listKlient')->send();
        }catch (\Exception $e){
            DB::rollback();
            return Redirect::back()
                ->withInput(Input::all())
                ->withErrors($e->getMessage());
        }

    }

    public function view($id){
        if (is_numeric($id) && isset($id)){
            $klienti = KlientModel::select(KlientClass::TABLE_NAME.'.'.KlientClass::ID,KlientClass::TABLE_NAME.'.'.KlientClass::EMRI,
                KlientClass::TABLE_NAME.'.'.KlientClass::MBIEMRI, KlientClass::TABLE_NAME.'.'.KlientClass::EMAIL,
                KlientClass::TABLE_NAME.'.'.KlientClass::CEL )
                ->where(KlientClass::TABLE_NAME.'.'.KlientClass::ID, $id)
                ->first();

            $librat = HuazimModel::select(HuazimClass::TABLE_NAME.'.'.HuazimClass::ID, HuazimClass::TABLE_NAME.'.'.HuazimClass::DATA_DOREZIMIT,
                                        LibriClass::TABLE_NAME.'.'.LibriClass::TITULLI,
                                        LibriClass::TABLE_NAME.'.'.LibriClass::VITI, AutoriClass::TABLE_NAME.'.'.AutoriClass::EMRI,
                                        AutoriClass::TABLE_NAME.'.'.AutoriClass::MBIEMRI, LibriClass::TABLE_NAME.'.'.LibriClass::VITI)
                ->join(LibriClass::TABLE_NAME, LibriClass::TABLE_NAME.'.'.LibriClass::ID, HuazimClass::TABLE_NAME.'.'.HuazimClass::ID_LIBRI)
                ->join(AutoriClass::TABLE_NAME, AutoriClass::TABLE_NAME.'.'.AutoriClass::ID, LibriClass::TABLE_NAME.'.'.LibriClass::ID_AUTOR)
                ->where(HuazimClass::TABLE_NAME.'.'.HuazimClass::ID_KLIENT, $id)
                ->where(HuazimClass::TABLE_NAME.'.'.HuazimClass::KTHYER, HuazimClass::I_PAKTHYER)
                ->where(HuazimClass::TABLE_NAME.'.'.HuazimClass::SHITUR, 0)
                ->get();

            return view('backend.klient.view')
                ->with('klienti', $klienti)
                ->with('librat', $librat)
                ;
        }
    }
}
