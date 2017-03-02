@extends('layouts.prime')
@section('pageTitle')
    Dashboard - Klientë
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
                <h3 class="box-title">Klientë</h3>
            </div>

            <div class="box-body">
                <div class="row">
                <div class="col-sm-2" style="margin-bottom: 16px;">
                    <a href="{!! URL::route('krijoKlient') !!}" class="btn btn-success">
                        <i class="fa fa-plus"></i> Krijo
                    </a>
                </div>
                </div>
            <div class="row">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>EMRI</th>
                        <th>MBIEMRI</th>
                        <th>EMAIL</th>
                        <th>CEL</th>
                        <th>NR. LIBRAVE TE HUAZUAR</th>
                        <th>VEPRIME</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($klient as $l)
                        <tr>
                            <td>{!! $l->emri !!}</td>
                            <td>{!! $l->mbiemri !!}</td>
                            <td>{!! $l->email !!}</td>
                            <td>0{!! $l->cel !!}</td>
                            <td>
                                <?php
                                $librat = \App\Models\HuazimModel::where(\App\Http\Controllers\Classes\HuazimClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\HuazimClass::ID_KLIENT,
                                    $l->klient_id)
                                    ->where(\App\Http\Controllers\Classes\HuazimClass::KTHYER, \App\Http\Controllers\Classes\HuazimClass::I_PAKTHYER)
                                    ->get();

                                echo count($librat);

                                ?>
                            </td>
                            <td>
                                <a href="#" class="btn btn-default">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                {{--<a href="{!! URL::route('viewLibri', array($l->klient_id)) !!}" class="btn btn-info">--}}
                                    {{--<i class="fa fa-eye"></i>--}}
                                {{--</a>--}}

                                <a href="{!! URL::route('shikoKlient', array($l->klient_id)) !!}" class="btn btn-default">
                                    <i class="fa fa-eye"></i>
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
                "autoWidth": true
            });
        });
    </script>
@endsection