<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\AutoriClass;
use App\Http\Controllers\Classes\LibriClass;
use App\Models\AutorModel;
use App\Models\LibriModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class AutorController extends Controller
{
    public function categories(){
        return view('backend.categories');
    }

    public function index(){
        $autor = AutorModel::select(AutoriClass::TABLE_NAME.'.'.AutoriClass::ID, AutoriClass::TABLE_NAME.'.'.AutoriClass::EMRI,
            AutoriClass::TABLE_NAME.'.'.AutoriClass::MBIEMRI)
            ->get();

        return view('backend.autor.view')
            ->with('autor', $autor)
            ;
    }

    public function create(){
        return view('backend.autor.create');
    }

    public function ruaj(Request $request){

        try{

            $emri = htmlentities(trim($request->emri));
            $mbiemri = htmlentities(trim($request->mbiemri));

            $new = new AutorModel();
            $new->emri = $emri;
            $new->mbiemri = $mbiemri;
            $new->save();

            $id = DB::getPDO()->lastInsertId();
            return [
                'sts' => 1,
                'id' => $id
            ];

        } catch (Exception $e) {
            return [
                'sts' => 0,
                'error' => $e->getMessage()
            ];

        }

    }

    public function fshi(Request $request){
        if (isset($request->id) && is_numeric($request->id)){
            $id = htmlentities($request->id);

            $libri = LibriModel::where(LibriClass::TABLE_NAME.'.'.LibriClass::ID_AUTOR, $id )
                ->get();
            if (count($libri) > 0 ){
                return [
                    'sts' => 2,
                    'error' => "Autori ka libra aktive, nuk mund te fshihet"
                ];
            }
            $done = AutorModel::where(AutoriClass::TABLE_NAME.'.'.AutoriClass::ID, $id)
                ->delete();

            if ($done){
                return [
                    'sts' => 1
                ];
            }else{
                return [
                    'sts' => 0,
                    'error' => 'Autori nuk mund te fshihet, dicka shkoi keq ne server!'
                ];
            }
        }
    }

    public function view($id){
        if (is_numeric($id) && isset($id)){
            $autor = AutorModel::select(AutoriClass::TABLE_NAME.'.'.AutoriClass::ID,AutoriClass::TABLE_NAME.'.'.AutoriClass::EMRI,
                AutoriClass::TABLE_NAME.'.'.AutoriClass::MBIEMRI )
                ->where(AutoriClass::TABLE_NAME.'.'.AutoriClass::ID, $id)
                ->first();


            return view('backend.klient.view')
                ->with('klienti', $autor)
                ;
        }
    }

}
