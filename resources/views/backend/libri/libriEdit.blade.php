@extends('layouts.prime')
@section('pageTitle')
    Dashboard - Librat - Edito
@endsection
@section('main_container')
    <div class="row">
        <div class="box">
            <div class="box-header">
                <div style="background-color:#f5f5f5 !important; height: 60px;">
                    <h3 class="box-title" style="margin-top: 0px;">Edito librin</h3>
                </div>
            </div>

            {!! Form::open(array('route' => 'updateLiber', 'id'=>'krijoLiber', 'method'=>'post', 'files'=>true)) !!}
            <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Titulli</label>
                        <input type="text" name="title" value="{!! $libri->titulli !!}" class="form-control" placeholder="Titulli">
                        <span class="validate-error"></span>

                    </div>

                    <div class="form-group">
                        <label>Përshkrimi</label>
                        <textarea name="description" class="form-control" rows="3" >{!! $libri->desc !!}</textarea>
                        <span class="validate-error"></span>

                    </div>

                    {{--{!! count($autor) !!}--}}
                    <div class="form-group">
                        <label>Autori</label>
                        {{--{!! $libri->id_autor !!}--}}
                        <select name="autori" class="form-control select2 select2-hidden-accessible" data-placeholder="Zgjidh autor"
                                style="width: 100%;" tabindex="-1" aria-hidden="true">
                            @foreach($autor as $a)
                                @if($a->autor_id == $libri->id_autor)
                                    <option value="{!! $a->autor_id !!}" selected> {!! $a->emri !!} {!! $a->mbiemri !!} </option>
                                @else
                                    <option value="{!! $a->autor_id !!}" > {!! $a->emri !!} {!! $a->mbiemri !!} </option>
                                @endif
                            @endforeach
                        </select>
                        <span class="validate-error"></span>

                    </div>

                    <div class="form-group">
                        <label>Zhanri</label>
                        {{--{!! count($zhanri) !!}--}}
                        {{--{!! print_r($zhanriLibrit) !!}--}}
                        <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Zgjidh zhaner"
                                style="width: 100%;" tabindex="-1" name="zhanri[]" aria-hidden="true">
                            @foreach($zhanri as $a)
                                {{--<option value="a">{!! $a->zhanri_id !!}</option>--}}
                                @if(in_array($a->zhanri_id, $zhanriLibrit))
                                    <option value="{!! $a->zhanri_id !!}" selected> {!! $a->emri !!}</option>
                                @else
                                    <option value="{!! $a->zhanri_id !!}"> {!! $a->emri !!}</option>
                                @endif
                            @endforeach
                        </select>
                        <span class="validate-error"></span>

                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label>Cmimi</label>
                        <input type="number" name="cmimi" value="{!! $libri->cmimi !!}" class="form-control" placeholder="Cmimi">
                        <span class="validate-error"></span>

                    </div>

                    <div class="form-group">
                        <label>Viti Botimit</label>

                        <input type="number" value="{!! $libri->viti !!}" name="viti" class="form-control pull-right" >
                        <span class="validate-error"></span>

                    </div>

                    <div class="form-group">
                        <label>Shtëpia Botuese</label>
                        <input type="text" name="shtepia" value="{!! $libri->shtepi_botuese !!}" class="form-control" placeholder="Shtëpia botimit">
                        <span class="validate-error"></span>

                    </div>

                    <div class="form-group">
                        <label for="foto">Foto Librit</label>
                        <input type="file" id="foto">

                        <p class="help-block">
                        </p>
                    </div>
                </div>
                <input type="hidden" name="idlibri" value="{!! $libri->libri_id !!}">

                <div class="col-sm-1">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
                {!! Form::close() !!}
            </div>
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
//                format: 'yyyy-mm-dd',
//                autoclose: true
//            });

            $("#krijo").click(function () {
                $("#updateLiber").submit();
            });
        });
    </script>
@endsection