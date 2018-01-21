<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Classes\LibriToZhanriClass;
use App\Http\Controllers\Classes\ZhanriClass;
use App\Models\CategoryModel;
use App\Models\LibriToZhanriModel;
use App\Models\ZhanriModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;

class ZhanriController extends Controller
{

    public function save(Request $request)
    {

        if (isset($request->emri)){
            try {

                $category = new ZhanriModel();
                $category->emri = htmlentities(trim($request->emri));
                $category->save();

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

    }

    //fshin zhanerin nga db
    public function fshi(Request $request){
//        echo $request->id;die();
        if (isset($request->id)){

            $exists = LibriToZhanriModel::where(LibriToZhanriClass::TABLE_NAME.'.'.LibriToZhanriClass::ID_ZHANRI,
                htmlentities(trim($request->id)))
                ->first();

            if($exists){
                return [
                    'sts' => 2
                ];
            }

            $zhanri = ZhanriModel::where(ZhanriClass::TABLE_NAME.'.'.ZhanriClass::ID, htmlentities(trim($request->id)))
                ->delete();

            if ($zhanri){
                return [
                    'sts'=> 1,
                ];
            }else{
                return [
                    'sts' => 2
                ];
            }
        }else{
            return [
                'sts' => 0
            ];
        }
    }

    public function view(){
        $zhanri = ZhanriModel::get();

        return view('backend.zhaner.view')
            ->with("zhanri", $zhanri)
            ;
    }
}
