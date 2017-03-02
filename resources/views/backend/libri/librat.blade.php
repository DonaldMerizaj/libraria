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
                <div class="row">
                    @if(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::ADMIN)
                    <div class="col-sm-2" style="margin-bottom: 16px;">
                        <a href="{!! URL::route('krijoLiber') !!}" class="btn btn-success">
                            <i class="fa fa-plus"></i> Krijo
                        </a>
                    </div>
                        @endif
                </div>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>TITULLI</th>
                            <th>AUTORI</th>
                            <th>ZHANRI</th>
                            <th>VITI</th>
                            <th>CMIMI</th>
                            @if(\App\Http\Controllers\Utils::getRole() <= \App\Http\Controllers\Classes\LoginClass::PUNONJES)
                            <th>SASIA GJENDJE</th>
                            @endif
                            <th>VEPRIME</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($librat as $l)
                        <tr>
                            <td>{!! $l->titulli !!}</td>
                            <td>{!! $l->emri !!} {!! $l->mbiemri !!}</td>
                            <td style="word-break: break-all;">
                                <?php
                                $zhanri = \App\Models\LibriToZhanriModel::select(
                                    \App\Http\Controllers\Classes\ZhanriClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\ZhanriClass::EMRI)
                                    ->join(\App\Http\Controllers\Classes\ZhanriClass::TABLE_NAME,
                                        \App\Http\Controllers\Classes\ZhanriClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\ZhanriClass::ID,
                                        \App\Http\Controllers\Classes\LibriToZhanriClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\LibriToZhanriClass::ID_ZHANRI)
                                    ->where(\App\Http\Controllers\Classes\LibriToZhanriClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\LibriToZhanriClass::ID_LIBRI,
                                        $l->libri_id)
                                    ->get();
//echo count($zhanri).'/'.$l->libri_id;
                                if (count($zhanri) > 0){

                                    echo $zhanri[0]->emri;
                                    for($i = 1; $i < count($zhanri); $i++){
                                        echo ', '.$zhanri[$i]->emri;
                                    }
                                }else{
                                    echo '--';
                                }

                                ?>
                            </td>
                            <td>{!! $l->viti !!}</td>
                            <td>{!! $l->cmimi !!}</td>
                            @if(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::KLIENT && ($l->gjendje>0))
                                <td>Ka gjendje</td>
                                @elseif(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::KLIENT && ($l->gjendje==0))
                                    <td>Nuk ka gjendje</td>
                                @else
                                <td>{!! $l->gjendje !!}</td>
                            @endif
                            <td>
                                @if(\App\Http\Controllers\Utils::getRole() <= \App\Http\Controllers\Classes\LoginClass::ADMIN)
                                <a href="{!! URL::route('editLibri', array($l->libri_id)) !!}" class="btn btn-default">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                @endif
                                <a href="#" class="btn btn-info">
                                    <i class="fa fa-eye"></i>
                                </a>
                                    @if(($l->gjendje>0))
                                        @if(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::KLIENT )

                                        @elseif(\App\Http\Controllers\Utils::getRole() <= \App\Http\Controllers\Classes\LoginClass::PUNONJES)
                                        <a href="{!! URL::route('huazoLiber', array($l->libri_id)) !!}" class="btn btn-default">
                                        <i class="fa fa-money"></i>
                                        @endif
                                    @endif
                                </a>
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
                "autoWidth": false
            });
        });
    </script>
@endsection