<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\AutoriClass;
use App\Http\Controllers\Classes\HuazimClass;
use App\Http\Controllers\Classes\InventarClass;
use App\Http\Controllers\Classes\KlientClass;
use App\Http\Controllers\Classes\LibriClass;
use App\Http\Controllers\Classes\LibriToZhanriClass;
use App\Http\Controllers\Classes\ZhanriClass;
use App\Models\AutorModel;
use App\Models\HuazimModel;
use App\Models\InventarModel;
use App\Models\KlientModel;
use App\Models\LibriModel;
use App\Models\LibriToZhanriModel;
use App\Models\ZhanriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

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

        return view('backend.libri.librat')
            ->with('librat', $librat);
    }

    public function create(){
        $zhanri = ZhanriModel::select(ZhanriClass::TABLE_NAME.'.'.ZhanriClass::EMRI, ZhanriClass::TABLE_NAME.'.'.ZhanriClass::ID)
                    ->get();
        $autor = AutorModel::select(AutoriClass::TABLE_NAME.'.'.AutoriClass::EMRI, AutoriClass::TABLE_NAME.'.'.AutoriClass::MBIEMRI,
                                    AutoriClass::TABLE_NAME.'.'.AutoriClass::ID)
                    ->get();
        return view('backend.libri.create')
            ->with('zhanri' , $zhanri)
            ->with('autor' , $autor)
            ;
    }

    public function ruaj(Request $request){
        try{

            DB::beginTransaction();

            $title = htmlentities(trim($request->title));
            $desc = htmlentities(trim($request->description));
            $shtepia = htmlentities(trim($request->shtepia));
            $cmimi = htmlentities(trim($request->cmimi));
            $autori = is_numeric($request->autori) ? $request->autori : 0;
            $date = str_replace('/', '-', $request->viti);
            $viti = date('Y-m-d', strtotime($date));
//            echo $viti;die();
            if ($request->hasFile('foto')){

                if (Input::file('foto')->isValid()){
                    $image = Utils::ruajFoto('foto');
                }else{
                    return Redirect::back()->withInput(all())->withErrors('Foto nuk eshte e vlefshme!');
                }
            }else{
//                echo 1;die();
                $image = '';
            }

            $new = new LibriModel();
            $new->titulli = $title;
            $new->id_autor = $autori;
            $new->desc = $desc;
            $new->cmimi = $cmimi;
            $new->shtepi_botuese = $shtepia;
            $new->viti = $viti;
            $new->image = $image;
            $new->save();

            $lastId = DB::getPdo()->lastInsertId();


            foreach ($request->zhanri as $z){

                $newZhaner = new LibriToZhanriModel();
                $newZhaner->id_libri = $lastId;
                $newZhaner->id_zhanri = $z;
                $newZhaner->save();
//                echo $z;
            }
//echo 'a';die();
            $newInv = new InventarModel();
            $newInv->sasia_hyrje = $request->sasia ? $request->sasia : 0;
            $newInv->id_libri = $lastId;
            $newInv->gjendje = $request->sasia ? $request->sasia : 0;
            $newInv->save();

            DB::commit();

            return Redirect::route('listLibrat')->send();
        }catch (\Exception $e){
            DB::rollback();
            return Redirect::back()
                ->withInput(Input::all())
                ->withErrors($e->getMessage());
        }
    }

    public function edit($id){
        if (isset($id) && is_numeric($id)){
            $libri = LibriModel::select(LibriClass::TABLE_NAME.'.'.LibriClass::TITULLI,LibriClass::TABLE_NAME.'.'.LibriClass::ID,
                LibriClass::TABLE_NAME.'.'.LibriClass::CMIMI, LibriClass::TABLE_NAME.'.'.LibriClass::SHTEPI_BOTUESE,
                LibriClass::TABLE_NAME.'.'.LibriClass::VITI, AutoriClass::TABLE_NAME.'.'.AutoriClass::EMRI,LibriClass::TABLE_NAME.'.'.LibriClass::DESC,
                AutoriClass::TABLE_NAME.'.'.AutoriClass::MBIEMRI, InventarClass::TABLE_NAME.'.'.InventarClass::GJENDJE)
                ->join(AutoriClass::TABLE_NAME, AutoriClass::ID, LibriClass::TABLE_NAME.'.'.LibriClass::ID_AUTOR)
                ->join(InventarClass::TABLE_NAME, InventarClass::ID_LIBRI, LibriClass::TABLE_NAME.'.'.LibriClass::ID)
                ->where(LibriClass::TABLE_NAME.'.'.LibriClass::ID, $id)
                ->first();
            $autor = AutorModel::select(AutoriClass::TABLE_NAME.'.'.AutoriClass::EMRI, AutoriClass::TABLE_NAME.'.'.AutoriClass::MBIEMRI,
                AutoriClass::TABLE_NAME.'.'.AutoriClass::ID)
                ->get();
            $zhanri = ZhanriModel::select(ZhanriClass::TABLE_NAME.'.'.ZhanriClass::EMRI, ZhanriClass::TABLE_NAME.'.'.ZhanriClass::ID)
                ->get();
            $zhanriLibrit = LibriToZhanriModel::select(LibriToZhanriClass::TABLE_NAME.'.'.LibriToZhanriClass::ID_ZHANRI)
                ->join(LibriClass::TABLE_NAME, LibriClass::TABLE_NAME.'.'.LibriClass::ID,
                    LibriToZhanriClass::TABLE_NAME.'.'.LibriToZhanriClass::ID_LIBRI)
                ->get();
            $zhanriLiber = array();
            foreach ($zhanriLibrit as $z){
                array_push($zhanriLiber, $z->id_zhanri);
            }
//            print_r($zhanriLiber);die();
//            echo count($autor).' zhanri:'.count($zhanriLibrit);die();
            if (count($libri) > 0){
                return view('backend.libri.libriEdit')
                    ->with('libri', $libri)
                    ->with('autor', $autor)
                    ->with('zhanri', $zhanri)
                    ->with('zhanriLibrit', $zhanriLiber)
                    ;
            }else{
                abort(404);
            }

        }else{
            abort(404);
        }
    }

    public function update(Request $request){
        try{

            DB::beginTransaction();

            $title = htmlentities(trim($request->title));
            $desc = htmlentities(trim($request->description));
            $shtepia = htmlentities(trim($request->shtepia));
            $cmimi = htmlentities(trim($request->cmimi));
            $autori = $request->autori;
            $date1 = str_replace('/', '-', $request->viti_botimit);
            $viti = date('Y-m-d', strtotime($date1));

//            echo $request->viti.'..'.$date;die();
            $libri = LibriModel::where(LibriClass::TABLE_NAME.'.'.LibriClass::ID, $request->idlibri)->first();

            $vitibotimit = date('Y-m-d', strtotime($libri->viti));
//echo $date1.'.'.$viti.'.'.$vitibotimit;die();
            $fields = array();
            if ($title != $libri->titulli){
                $fields = array_merge($fields,[
                    'titulli' => $title
                ]);
            }
            if ($desc != $libri->desc){
                $fields = array_merge($fields,[
                    'desc' => $desc
                ]);
            }
            if ($shtepia != $libri->shtepi_botuese){
                $fields = array_merge($fields,[
                    'shtepi_botuese' => $shtepia
                ]);
            }
            if ($cmimi != $libri->cmimi){
                $fields = array_merge($fields,[
                    'cmimi' => $cmimi
                ]);
            }
            if ($autori != $libri->autori){
                $fields = array_merge($fields,[
                    'id_autor' => $autori
                ]);
            }
            if ($viti != $vitibotimit){
                $fields = array_merge($fields,[
                    'viti' => $viti
                ]);
            }



            LibriModel::where(LibriClass::TABLE_NAME.'.'.LibriClass::ID,
                                        $request->idlibri)
                        ->update($fields);

            DB::commit();

            return Redirect::route('listLibrat')->send();
        }catch (\Exception $e){
            DB::rollback();
//            echo $e->getMessage();die();
            return Redirect::back()
                ->withInput(Input::all())
                ->withErrors($e->getMessage());
        }
    }

    public function huazo($id){

        if (isset($id) && is_numeric($id)){
            $libri = LibriModel::select(LibriClass::TABLE_NAME.'.'.LibriClass::TITULLI,LibriClass::TABLE_NAME.'.'.LibriClass::ID,
                LibriClass::TABLE_NAME.'.'.LibriClass::CMIMI, LibriClass::TABLE_NAME.'.'.LibriClass::SHTEPI_BOTUESE,
                LibriClass::TABLE_NAME.'.'.LibriClass::VITI, AutoriClass::TABLE_NAME.'.'.AutoriClass::EMRI,LibriClass::TABLE_NAME.'.'.LibriClass::DESC,
                AutoriClass::TABLE_NAME.'.'.AutoriClass::MBIEMRI)
                ->join(AutoriClass::TABLE_NAME, AutoriClass::ID, LibriClass::TABLE_NAME.'.'.LibriClass::ID_AUTOR)
                ->where(LibriClass::TABLE_NAME.'.'.LibriClass::ID, $id)
                ->first();
//            $autor = AutorModel::select(AutoriClass::TABLE_NAME.'.'.AutoriClass::EMRI, AutoriClass::TABLE_NAME.'.'.AutoriClass::MBIEMRI,
//                AutoriClass::TABLE_NAME.'.'.AutoriClass::ID)
//                ->get();
//            $zhanri = ZhanriModel::select(ZhanriClass::TABLE_NAME.'.'.ZhanriClass::EMRI, ZhanriClass::TABLE_NAME.'.'.ZhanriClass::ID)
//                ->get();
            $zhanriLibrit = LibriToZhanriModel::select(ZhanriClass::TABLE_NAME.'.'.ZhanriClass::EMRI)
                ->join(LibriClass::TABLE_NAME, LibriClass::TABLE_NAME.'.'.LibriClass::ID,
                    LibriToZhanriClass::TABLE_NAME.'.'.LibriToZhanriClass::ID_LIBRI)
                ->join(ZhanriClass::TABLE_NAME, ZhanriClass::TABLE_NAME.'.'.ZhanriClass::ID,
                    LibriToZhanriClass::TABLE_NAME.'.'.LibriToZhanriClass::ID_ZHANRI)
                ->where(LibriToZhanriClass::TABLE_NAME.'.'.LibriToZhanriClass::ID_LIBRI, $id)
                ->get();

            $klient = KlientModel::select(KlientClass::TABLE_NAME.'.'.KlientClass::ID,KlientClass::TABLE_NAME.'.'.KlientClass::EMRI,
                KlientClass::TABLE_NAME.'.'.KlientClass::MBIEMRI, KlientClass::TABLE_NAME.'.'.KlientClass::EMAIL,
                KlientClass::TABLE_NAME.'.'.KlientClass::CEL )
                ->get();
            if (count($libri) > 0){
                return view('backend.libri.huazo')
                    ->with('libri', $libri)
                    ->with('klient', $klient)
//                    ->with('zhanri', $zhanri)
                    ->with('zhanri', $zhanriLibrit)
                    ;
            }else{
                abort(404);
            }

        }else{
            abort(404);
        }
    }

    public function kthe(Request $request){
        try {
            DB::beginTransaction();
            if (is_numeric($request->id)) {
                $h = HuazimModel::where(HuazimClass::TABLE_NAME . '.' . HuazimClass::ID, $request->id)
                    ->first();
                if (count($h) > 0) {
                    $id_libri = $h->id_libri;
                } else {
                    return [
                        'status' => 0,
                        'error' => 'Ky user nuk e ka kete liber!'
                    ];
                }

                $done = HuazimModel::where(HuazimClass::TABLE_NAME . '.' . HuazimClass::ID, $request->id)
                    ->update(['kthyer' => 1]);

                $inv = InventarModel::where(InventarClass::TABLE_NAME.'.'.InventarClass::ID_LIBRI, $id_libri)
                    ->first();
                $inv = $inv->gjendje +1;
                InventarModel::where(InventarClass::TABLE_NAME.'.'.InventarClass::ID_LIBRI, $id_libri)
                    ->update(['gjendje'=> $inv]);

                DB::commit();

                return [
                    'status' => 1,
                    'data' => 'Kthimi i librit u krye me sukses!'
                ];
            }else{
                return [
                    'status' => 0,
                    'error' => 'Ndodhi gabim gjat kryerjes se veprimit, provo perseri me vone!'
                ];
            }
        }catch (\Exception $e){
            DB::rollback();
            return [
                'status' => 0,
                'error' => $e->getMessage()
            ];
        }
    }

}


