<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\HuazimClass;
use App\Http\Controllers\Classes\InventarClass;
use App\Http\Controllers\Classes\LibriClass;
use App\Models\HuazimModel;
use App\Models\InventarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class InventarController extends Controller
{
    public function raporte(){
//        try{
            //libri me i huazuar
//            $libri = DB::select('');

            //gjendja e librave ne inventar
            $inv = InventarModel::select(InventarClass::TABLE_NAME.'.'.InventarClass::GJENDJE,
                                        LibriClass::TABLE_NAME.'.'.LibriClass::TITULLI, InventarClass::TABLE_NAME.'.'.InventarClass::SASIA)
                ->join(LibriClass::TABLE_NAME, LibriClass::TABLE_NAME.'.'.LibriClass::ID, InventarClass::ID_LIBRI)
//                ->join(HuazimClass::TABLE_NAME, HuazimClass::TABLE_NAME.'.'.HuazimClass::ID_LIBRI, LibriClass::TABLE_NAME.'.'.LibriClass::ID)
                ->get();

            //librat e huazuar 3 muajt e fundit
            $huazim = DB::select('SELECT DISTINCT(huazimi.libriId), huazimi.sasia, l.titulli
                                    from (
                                        SELECT SUM(sasia) as sasia, h.id_libri as libriId
                                        FROM huazim as h
                                        WHERE datediff(CURRENT_DATE(),h.data_marrjes)<90
                                        GROUP BY (h.id_libri)
                                        ) as 
                                        huazimi
                                 JOIN libri as l 
                                 ON huazimi.libriId=l.libri_id');

            //klientet e rinj muajin e fundit
            $klient = DB::select('SELECT k.emri, k.mbiemri
                                  from klient as k
                                  where datediff(CURRENT_DATE(),k.created_at)<30');

            //librat qe kane kaluar afatin
            $jashteAfati = DB::select('SELECT titulli 
                                        FROM libri as l 
                                        JOIN huazim as h 
                                          ON l.libri_id=h.id_libri 
                                      WHERE datediff(CURRENT_DATE(),data_dorezimit)>0 and h.kthyer=0 AND h.shitur = 0');
            $huazuar = DB::select('SELECT titulli 
                                        FROM libri as l 
                                        JOIN huazim as h 
                                          ON l.libri_id=h.id_libri 
                                          where h.shitur = 0 and h.kthyer=0');
//                                      WHERE datediff(CURRENT_DATE(),data_dorezimit)>0 and h.kthyer=1');

        if (count($huazuar) > 0){
            $raporti = round((count($jashteAfati)/count($huazuar))*100);
        }else{
            $raporti = 0;
        }
            $sasia_nr = count($jashteAfati);
            //librat me pak se 3 ne gjendje
            $libramin = DB::select('SELECT l.titulli, l.cmimi
                                    from inventar as i, libri as l
                                    where i.id_libri = l.libri_id and i.gjendje < 3');


            $shitje = DB::select('SELECT SUM(cmimi) as total, COUNT(libri_id) as nr
                                        FROM libri as l 
                                        JOIN huazim as h 
                                          ON l.libri_id=h.id_libri
                                       WHERE shitur = 1');
//            echo $shitje[0]->total.'/'.$shitje[0]->nr;die();
            return view('backend.raporte')
                ->with('librat', $inv)
                ->with('huazim', $huazim)
                ->with('klient', $klient)
                ->with('raporti', $raporti)
                ->with('sasia_nr', $sasia_nr)
                ->with('shitje', $shitje)
                ->with('libramin', $libramin)
                ;
//        }
//        catch(\Exception $e){
//            return Redirect::back()->withErrors($e->getMessage());
//        }
    }
}
