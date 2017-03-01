@extends('layouts.prime')
@section('pageTitle')
    Dashboard - Librat
@endsection
@section('main_container')
    {{--<div class="row">--}}
    {{--<div class="col-sm-12">--}}
    {{--<h1>Menaxho librat</h1>--}}
    {{--</div>--}}
    {{--</div>--}}
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Librat</h3>
            </div>

            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>TITULLI</th>
                        <th>AUTORI</th>
                        <th>ZHANRI</th>
                        <th>VITI</th>
                        <th>SASIA GJENDJE</th>
                        <th>VEPRIME</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($librat as $l)
                        <tr>
                            <td>{!! $l->titulli !!}</td>
                            <td>{!! $l->emri !!} {!! $l->mbiemri !!}</td>
                            <td>
                                <?php
                                $zhanri = \App\Models\LibriToZhanriModel::select(
                                    \App\Http\Controllers\Classes\ZhanriClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\ZhanriClass::EMRI)
                                    ->join(\App\Http\Controllers\Classes\ZhanriClass::TABLE_NAME,
                                        \App\Http\Controllers\Classes\ZhanriClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\ZhanriClass::ID,
                                        \App\Http\Controllers\Classes\LibriToZhanriClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\LibriToZhanriClass::ID_ZHANRI)
                                    ->where(\App\Http\Controllers\Classes\LibriToZhanriClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\LibriToZhanriClass::ID_LIBRI,
                                        $l->libri_id)
                                    ->get();

                                if (count($zhanri) > 1){
                                    foreach ($zhanri as $z){
                                        echo $zhanri->emri.' ' ;
                                    }
                                }

                                ?>
                            </td>
                            <td>{!! $l->viti !!}</td>
                            <td>{!! $l->cmimi !!}</td>
                            <td>{!! $l->gjendje !!}</td>
                            <td>
                                <a href="#" class="btn btn-default">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                {{--<a href="#" class="btn btn-info">--}}
                                    {{--<i class="fa fa-eye"></i>--}}
                                {{--</a>--}}
                                <button data-id="{!! $l->libri_id !!}" class="huazoLibrin btn btn-warning">
                                    <i class="fa fa-money"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <script>
        $(function () {
//            $("#example1").DataTable();
            $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });
        });
    </script>
@endsection