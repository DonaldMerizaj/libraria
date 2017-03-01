@extends('layouts.prime')
@section('pageTitle')
    Dashboard - Raporte
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
                <h3 class="box-title">Raporte</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 style="text-align: center; width: 70%;" class="box-title">Librat jashte afatit</h3>
                        <h4 style="text-align: center; width: 70%; background-color: #FF7043; color: #fff;">{!! $sasia_nr !!} libra = {!! $raporti !!} %  </h4>
                    </div>

                    <div class="col-sm-6">
                        <h3 style="text-align: center; width: 70%;" class="box-title">Librat e shitur</h3>
                        <h4 style="text-align: center; width: 70%; background-color: #2bdb72; color: #fff;">{!! $shitje[0]->nr !!} libra = {!! $shitje[0]->total !!} lekë  </h4>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="box-title">Gjendja e inventarit</h3>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>TITULLI</th>
                                <th>GJENDJE</th>
                                <th>TOTALI</th>
                                <th>RAPORTI HUAZIMIT</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($librat as $l)
                                <tr>
                                    <td>{!! $l->titulli !!}</td>
                                    <td>{!! $l->gjendje !!}</td>
                                    <td>{!! $l->sasia_hyrje !!}</td>
                                    <td>
                                        <?php
                                        $raporti = round((($l->sasia_hyrje - $l->gjendje) / $l->sasia_hyrje), 2) *100;


                                            echo $raporti.' %';
                                        ?>  </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="box-title">Huazime 3 muajt e fundit</h3>
                        <table id="huazime" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>TITULLI</th>
                            <th>SASIA</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($huazim as $h)
                            <tr>
                                <td>{!! $h->titulli !!}</td>
                                <td>{!! $h->sasia !!}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                    </div>
                </div>
                <hr>

                <div class="row">
                <div class="col-sm-12">
                    <h3 class="box-title">Librat me me pak se 3 njesi</h3>
                    <table id="libramin" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>TITULLI</th>
                            <th>CMIMI</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($libramin as $h)
                            <tr>
                                <td>{!! $h->titulli !!}</td>
                                <td>{!! $h->cmimi !!}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="box-title">Klientet e rinj muajin e fundit</h3>
                        <table id="klientet" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>EMRI</th>
                                <th>MBIEMRI</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($klient as $h)
                                <tr>
                                    <td>{!! $h->emri !!}</td>
                                    <td>{!! $h->mbiemri !!}</td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
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
            $('#huazime').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });
            $('#klientet').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });
            $('#libramin').DataTable({
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