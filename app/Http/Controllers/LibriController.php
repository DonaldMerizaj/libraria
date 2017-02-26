<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\AutoriClass;
use App\Http\Controllers\Classes\InventarClass;
use App\Http\Controllers\Classes\KlientClass;
use App\Http\Controllers\Classes\LibriClass;
use App\Http\Controllers\Classes\LibriToZhanriClass;
use App\Http\Controllers\Classes\ZhanriClass;
use App\Models\AutorModel;
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
//            echo $date;die();
            if ($request->hasFile('foto')){

                if (Input::file('foto')->isValid()){
                    $image = Utils::ruajFoto('foto');
                }else{
                    return Redirect::back()->withInput(all())->withErrors('Foto nuk eshte e vlefshme!');
                }
            }else{
                echo 1;die();
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
                array_push($zhanriLiber, $z);
            }
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


}
