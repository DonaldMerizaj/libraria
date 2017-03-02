@extends('layouts.prime')
@section('pageTitle')
    Dashboard - Librat - Krijo
@endsection
@section('main_container')
    <div class="row">
        <div class="box">
            <div class="box-header">
                <div style="background-color:#f5f5f5 !important; height: 60px;">
                    <h3 class="box-title" style="margin-top: 0px;">Krijo libër</h3>
                </div>
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
                </div>
                {!! Form::open(array('route' => 'ruajLiber', 'id'=>'krijoLiber', 'method'=>'post', 'files'=>true)) !!}
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Titulli</label>
                        <input type="text" name="title" value="{!! old('title') !!}" class="form-control" placeholder="Titulli">
                        <span class="validate-error"></span>
                    </div>

                    <div class="form-group">
                        <label>Përshkrimi</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Përshkrimi">{!! old('description') !!}</textarea>
                        <span class="validate-error"></span>
                    </div>

                    <div class="form-group">
                        <label>Autori</label>
                        <select name="autori" class="form-control select2 select2-hidden-accessible" data-placeholder="Zgjidh autor"
                                style="width: 100%;" tabindex="-1" aria-hidden="true">
                            @foreach($autor as $a)
                                <option value="{!! $a->autor_id !!}">{!! $a->emri !!} {!! $a->mbiemri !!}</option>
                            @endforeach
                        </select>
                        <span class="validate-error"></span>
                    </div>

                    <div class="form-group">
                        <label>Zhanri</label>
                        <select class="form-control select2 select2-hidden-accessible" name="zhanri[]" multiple="" data-placeholder="Zgjidh zhaner"
                                style="width: 100%;" tabindex="-1" aria-hidden="true">
                            @foreach($zhanri as $a)
                                <option value="{!! $a->zhanri_id !!}">{!! $a->emri !!}</option>
                            @endforeach
                        </select>
                        <span class="validate-error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cmimi</label>
                        <input type="number" name="cmimi" class="form-control" value="{!! old('cmimi') !!}" placeholder="Cmimi">
                        <span class="validate-error"></span>
                    </div>
                    <div class="form-group">
                        <label>Viti Botimit</label>
                            <div class="">
                                <input type="number" value="{!! old('viti') !!}" name="viti" class="form-control pull-right">
                                <span class="validate-error"></span>
                            </div>

                    </div>
                    <div class="form-group">
                        <label>Shtëpia Botuese</label>
                        <input type="text" value="{!! old('shtepia') !!}" name="shtepia" class="form-control" placeholder="Shtëpia botimit">
                        <span class="validate-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto Librit</label>
                        <input type="file" name="foto" id="foto">

                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Sasia</label>
                            <input type="number" name="sasia" class="form-control" value="{!! old('sasia') !!}" placeholder="Sasia">
                            <small>*Sasia e librave nese ka hyrje ose 0 nese nuk ka</small>
                            <span class="validate-error"></span>
                        </div>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-1" style="margin-left: 16px;">
                    <button type="button" id="krijo" class="btn btn-success">Krijo</button>
                </div>
            </div>
                {!! Form::close() !!}
            </div>
        </div>

    <script>
        $(function () {
            $(".select2").select2();

            $('#krijoLiber').validate({
                rules: {
                    title: 'required',
                    description: 'required',
                    autori: 'required',
                    zhanri: 'required',
                    cmimi: 'required',
                    viti: {
                        required: true,
                        number:true,
                        minlength:4,
                        maxlength:4
                    },
                    shtepia: 'required'
                },
                messages: {
                    title: 'Vendosni titullin',
                    description: 'Vendosni pershkrimin',
                    autori: 'Zgjidhni autorin',
                    zhanri: 'Zgjidhni zhanrin',
                    cmimi: 'Vendosni cmimin',
                    viti: {
                        required: 'Zgjidhni vitin e botimit',
                        number: 'Viti duhet te jete numër',
                        minlength: 'Duhet të ketë 4 shifra',
                        maxlength: 'Duhet të ketë 4 shifra'
                    },
                    shtepia: 'Vendosni shtepine botuese'
                },
                errorPlacement: function (error, element) {
                    $.each(element, function () {
                        $(element).parent().find(".validate-error").html(error);
                    })
                }
            });

            //Date picker
//            $('#datepicker').datepicker({
//                format: 'dd/mm/yyyy',
//                autoclose: true
//            });

            $("#krijo").click(function () {
                $("#krijoLiber").submit();
            });
        })
    </script>
@endsection