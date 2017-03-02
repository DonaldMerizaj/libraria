@extends('layouts.prime')
@section('pageTitle')
    Dashboard - Libri - Huazo
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
                @if(count($errors)> 0)
                    <h4><i class="icon fa fa-ban"></i> Kujdes!</h4>
                    <ul style="list-style: none">
                        @foreach($errors->all() as $error)
                            <li class="alert alert-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="col-md-12" style="margin-bottom: 16px;">
                    <div class="col-md-6">
                        {!! Form::open(array('route' => 'huazoLibri', 'id'=>'huazoLiber', 'method'=>'post', 'files'=>true)) !!}
                        <div class="form-group">
                            <label>Titulli</label>
                            <h4 style="background-color: #f5f5f5;">{!! $libri->titulli !!}</h4>
                        </div>

                        <div class="form-group">
                            <label>Përshkrimi</label>
                           <textarea name="description" class="form-control" rows="3" disabled>{!! $libri->desc !!}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Autori</label>
                            <h4>{!! $libri->emri !!} {!! $libri->mbiemri !!}</h4>
                        </div>

                        <div class="form-group">
                            <label>Zhanri</label>
                            <ul style="list-style: none;">
                                @foreach($zhanri as $a)
                                    <li> <h4>{!! $a->emri !!}</h4></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="form-group">
                            <label>Cmimi</label>
                            <h4>{!! $libri->cmimi !!}</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Emri</label>
                                <input class="form-control" id="emriklient" type="text" value="" name="emriklient" placeholder="Emri" disabled>
                            </div>
                            <span class="validate-error"></span>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mbiemri</label>
                                <input class="form-control" id="mbiemriklient" type="text" value="" name="mbiemriklient" placeholder="Mbiemri" disabled>
                            </div>
                            <span class="validate-error"></span>
                        </div>
                    </div>
                    <div class="col-md-6" id="dataHuazimit">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Data marrjes</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" value="{!! old('dataMarrjes') !!}" name="dataMarrjes" class="form-control pull-right" id="datepicker">
                                </div>
                                <span class="validate-error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Data kthimit</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" value="{!! old('dataKthimit') !!}" name="dataKthimit" class="form-control pull-right" id="datepicker1">
                                </div>
                                <span class="validate-error"></span>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="klientId" name="klientId" value="">
                    <input type="hidden" id="libriId" name="libriId" value="{!! $libri->libri_id !!}">
                </div>
                    <div class="col-md-2">
                        <button type="button" id="krijo" class="btn btn-success" style="margin-bottom: 32px;" >Huazo</button>
                        <button type="button" id="shit" class="btn btn-info" style="margin-bottom: 32px;" >
                            <i class="fa fa-money"></i> Shit</button>
                    </div>
                {!! Form::close() !!}
                <br>
                <div class="col-md-12">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>EMRI</th>
                            <th>MBIEMRI</th>
                            <th>EMAIL</th>
                            <th>CEL</th>
                            <th>NR. LIBRAVE</th>
                            <th>VEPRIME</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($klient as $l)
                            <tr>
                                <td class="emriKlient">{!! $l->emri !!}</td>
                                <td  class="mbiemriKlient">{!! $l->mbiemri !!}</td>
                                <td>{!! $l->email !!}</td>
                                <td>0{!! $l->cel !!}</td>
                                <td>
                                    <?php
                                    $librat = \App\Models\HuazimModel::select(\App\Http\Controllers\Classes\HuazimClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\HuazimClass::ID_LIBRI)
                                        ->where(\App\Http\Controllers\Classes\HuazimClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\HuazimClass::ID_KLIENT,
                                        $l->klient_id)
                                        ->where(\App\Http\Controllers\Classes\HuazimClass::KTHYER, \App\Http\Controllers\Classes\HuazimClass::I_PAKTHYER)
                                        ->get();

                                    echo count($librat);

                                    ?>
                                </td>
                                <td>
                                    <a href="{!! URL::route('shikoKlient', array($l->klient_id)) !!}" class="btn btn-default">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <?php
                                    $librat = \App\Models\HuazimModel::select(\App\Http\Controllers\Classes\HuazimClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\HuazimClass::ID_LIBRI)
                                        ->where(\App\Http\Controllers\Classes\HuazimClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\HuazimClass::ID_KLIENT,
                                            $l->klient_id)
//                                        ->where(\App\Http\Controllers\Classes\HuazimClass::KTHYER, \App\Http\Controllers\Classes\HuazimClass::I_PAKTHYER)
                                        ->where(\App\Http\Controllers\Classes\HuazimClass::TABLE_NAME.'.'.\App\Http\Controllers\Classes\HuazimClass::ID_LIBRI, $libri->libri_id)
                                        ->get();
                                    if (count($librat) > 0){
                                            echo '';
                                    }else{
                                        echo '<button data-id="'. $l->klient_id .'"  class="huazoLibrin btn btn-info">
                                                    <i class="fa fa-plus"></i>
                                                </button>';
                                    }

                                    ?>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });

            $('#datepicker').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true
            });

            $('#datepicker1').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true
            });

            $('.huazoLibrin').click(function () {
                $('#dataHuazimit').removeClass('custom-hide');
                var a = $(this);
                var emri = $(a).parent().parent().find('.emriKlient').text();
                var mbiemri = $(a).parent().parent().find('.mbiemriKlient').text();
                var id = $(a).data("id");

                $('#emriklient').val(emri);
                $('#mbiemriklient').val(mbiemri);
                $('#klientId').val(id);
            });

            $('.shitLibrin').click(function () {
                $('#dataHuazimit').addClass('custom-hide');
                var a = $(this);
                var emri = $(a).parent().parent().find('.emriKlient').text();
                var mbiemri = $(a).parent().parent().find('.mbiemriKlient').text();
                var id = $(a).data("id");

                $('#emriklient').val(emri);
                $('#mbiemriklient').val(mbiemri);
                $('#klientId').val(id);
            });


//            $('#huazoLiber').validate({

//                rules: {
//                    emriklient: 'required',
//                    mbiemriklient: 'required',
//                    dataMarrjes: 'required',
//                    dataKthimit: 'required'

//                },
//                messages: {
//                    emriklient: 'Zgjidh klientin',
//                    mbiemriklient: 'Zgjidh klientin',
//                    dataMarrjes: 'Zgjidh daten e marrjes',
//                    dataKthimit: 'Zgjidh daten e kthimit'
//                },
//                errorPlacement: function (error, element) {
//                    $.each(element, function () {
//                        $(element).parent().parent().find(".validate-error").html(error);
//                    })
//                }
//            })


            $("#krijo").click(function () {
                var emri = $('#klientId').val();
                var marrja = $("input[name='dataMarrjes']").val();
                var kthimi = $("input[name='dataKthimit']").val();
                if ( emri == ''){
                    $('#emriklient').parent().parent().find('.validate-error').text('Zgjidhni klientin');
                }else
                    if (marrja == '' || kthimi == '') {
                        $('#emriklient').parent().parent().find('.validate-error').text('Zgjidhni datat');
                    }else{
                    $('#emriklient').parent().parent().find('.validate-error').text('');
//                    $('#emriklient').parent().parent().find('.validate-error').text('');
                    $("#huazoLiber").submit();
                }
            });

            $("#shit").click(function () {

                var emri = $('#klientId').val();
                if ( emri == ''){
                    $('#emriklient').parent().parent().find('.validate-error').text('Zgjidhni klientin');
                }else{
                    $('#emriklient').parent().parent().find('.validate-error').text('');
//                    $('#emriklient').parent().parent().find('.validate-error').text('');
                    $("#huazoLiber").submit();
                }
            });
        });
    </script>
@endsection