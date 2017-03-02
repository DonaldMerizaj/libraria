<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\InventarClass;
use App\Models\HuazimModel;
use App\Models\InventarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class HuazimController extends Controller
{
    public function ruajHuazim(Request $request){

        try{
            DB::beginTransaction();

            if (is_numeric($request->klientId) && is_numeric($request->libriId)){
                if ($request->dataMarrjes == '' || $request->dataMarrjes == null){
                    $new = new HuazimModel();
                    $new->id_klient = $request->klientId;
                    $new->id_user = Utils::getUserId();
                    $new->id_libri = $request->libriId;
                    $new->sasia = 1;
//                    $new->data_marrjes = time();
//                    $new->data_dorezimit = $kthim;
                    $new->kthyer = 1;
                    $new->shitur = 1;
                    $new->save();

                }else{
                    $date1 = str_replace('/', '-', $request->dataMarrjes);
                    $marrje = date('Y-m-d', strtotime($date1));

                    $date2 = str_replace('/', '-', $request->dataKthimit);
                    $kthim = date('Y-m-d', strtotime($date2));


                    $new = new HuazimModel();
                    $new->id_klient = $request->klientId;
                    $new->id_user = Utils::getLoginId();
                    $new->id_libri = $request->libriId;
                    $new->sasia = 1;
                    $new->data_marrjes = $marrje;
                    $new->data_dorezimit = $kthim;
                    $new->kthyer = 0;
                    $new->shitur = 0;
                    $new->save();
                }

                $inventar = InventarModel::where(InventarClass::TABLE_NAME.'.'.InventarClass::ID_LIBRI, $request->libriId)
                    ->first();

                if ($inventar->gjendje > 0){
                    $inv = $inventar->gjendje -1;
                    $updated = InventarModel::where(InventarClass::TABLE_NAME.'.'.InventarClass::ID_LIBRI, $request->libriId)
                        ->update(['gjendje' => $inv]);
                }
                DB::commit();
                return Redirect::route('listKlient')->send();

            }else{
                DB::rollback();
                return Redirect::back()
                    ->withInput(Input::all())
                    ->withErrors('Ndodhi nje gabim!');
            }
        }catch (\Exception $e){
            DB::rollback();
            return Redirect::back()
                ->withInput(Input::all())
                ->withErrors($e->getMessage());
        }

    }
}
