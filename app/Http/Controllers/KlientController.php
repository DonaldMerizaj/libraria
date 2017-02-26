<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\KlientClass;
use App\Models\KlientModel;
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
}
