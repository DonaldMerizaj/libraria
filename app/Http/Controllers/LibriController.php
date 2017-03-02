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
            $viti = $request->viti;

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
//print_r($request->zhanri);die();
            if ($request->zhanri != null) {
                foreach ($request->zhanri as $z) {

                    $newZhaner = new LibriToZhanriModel();
                    $newZhaner->id_libri = $lastId;
                    $newZhaner->id_zhanri = $z;
                    $newZhaner->save();
            //                echo $z;
                }
            }else{
                return Redirect::back()
                    ->withInput(Input::all())
                    ->withErrors("Zgjidhni zhanrin e librit!");
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
                LibriClass::TABLE_NAME.'.'.LibriClass::VITI, LibriClass::TABLE_NAME.'.'.LibriClass::ID_AUTOR,
                LibriClass::TABLE_NAME.'.'.LibriClass::DESC, InventarClass::TABLE_NAME.'.'.InventarClass::GJENDJE)
                ->join(AutoriClass::TABLE_NAME, AutoriClass::ID, LibriClass::TABLE_NAME.'.'.LibriClass::ID_AUTOR)
                ->join(InventarClass::TABLE_NAME, InventarClass::ID_LIBRI, LibriClass::TABLE_NAME.'.'.LibriClass::ID)
                ->where(LibriClass::TABLE_NAME.'.'.LibriClass::ID, $id)
                ->first();
            $autor = AutorModel::select(AutoriClass::TABLE_NAME.'.'.AutoriClass::EMRI, AutoriClass::TABLE_NAME.'.'.AutoriClass::MBIEMRI,
                AutoriClass::TABLE_NAME.'.'.AutoriClass::ID)
                ->get();
//            echo count($autor);die();
            $zhanri = ZhanriModel::select(ZhanriClass::TABLE_NAME.'.'.ZhanriClass::EMRI, ZhanriClass::TABLE_NAME.'.'.ZhanriClass::ID)
                ->get();
            $zhanriLibrit = LibriToZhanriModel::select(LibriToZhanriClass::TABLE_NAME.'.'.LibriToZhanriClass::ID_ZHANRI)
                ->where(LibriToZhanriClass::TABLE_NAME.'.'.LibriToZhanriClass::ID_LIBRI, $id)
                ->get();

            $zhanriLiber = array();
            foreach ($zhanriLibrit as $z){
                echo $z->id_zhanri;
                array_push($zhanriLiber, $z->id_zhanri);
            }
//print_r($zhanriLiber);die();
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
            $viti = $request->viti;

            $libri = LibriModel::where(LibriClass::TABLE_NAME.'.'.LibriClass::ID, $request->idlibri)->first();

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
            if ($viti != $libri->viti){
                $fields = array_merge($fields,[
                    'viti' => $viti
                ]);
            }

            $x=0;
            $zhanri = array();
            if($request->zhanri != null) {
//                print_r($request->zhanri);die();

                foreach ($request->zhanri as $c) {
                    $zhanri[$x] = $c;
                    $x++;
                }

//            print_r($zhanri);die();
                $ltozh = LibriToZhanriModel::select(LibriToZhanriClass::TABLE_NAME . '.' . LibriToZhanriClass::ID_ZHANRI,
                    LibriToZhanriClass::TABLE_NAME . '.' . LibriToZhanriClass::ID)
                    ->where(LibriToZhanriClass::TABLE_NAME . '.' . LibriToZhanriClass::ID_LIBRI, $request->idlibri)
                    ->get();
//            echo print_r($ltozh[0]);die();
                //shtuar
                for ($i = 0; $i < count($zhanri); $i++) {
                    $exist = false;
                    for ($j = 0; $j < count($ltozh); $j++) {
                        if ($zhanri[$i] == $ltozh[$j]->id_zhanri) {
                            $exist = true;
                            break;
                        }
                    }
                    if (!$exist) {
                        // insert new
                        $newZhaner = new LibriToZhanriModel();
                        $newZhaner->id_libri = $request->idlibri;
                        $newZhaner->id_zhanri = $zhanri[$i];
                        $newZhaner->save();
                    }
                }

                //fshire
                for ($i = 0; $i < count($ltozh); $i++) {
                    $deleted = true;
                    for ($j = 0; $j < count($zhanri); $j++) {
                        if ($ltozh[$i]->id_zhanri == $zhanri[$j]) {
                            $deleted = false;
                            break;
                        }
                    }
                    if ($deleted) {
                        LibriToZhanriModel::where(LibriToZhanriClass::TABLE_NAME . '.' . LibriToZhanriClass::ID, $ltozh[$i]->l_to_zh_id)
                            ->delete();
                    }
                }
            }else{
                return Redirect::back()
                    ->withInput(Input::all())
                    ->withErrors('Zgjidhni zhanrin');
            }

            LibriModel::where(LibriClass::TABLE_NAME.'.'.LibriClass::ID,
                                        $request->idlibri)
                        ->update($fields);
//echo 1;die();
            DB::commit();

            return Redirect::route('listLibrat')->send();
        }catch (\Exception $e){
            echo $e->getMessage().'//'.$e->getLine();die();
            DB::rollback();
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


