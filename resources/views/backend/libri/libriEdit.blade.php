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

            <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Titulli</label>
                        <input type="text" name="title" value="{!! $libri->titulli !!}" class="form-control" placeholder="Titulli">
                    </div>

                    <div class="form-group">
                        <label>Përshkrimi</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Përshkrimi">{!! $libri->desc !!}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Autori</label>
                        <select class="form-control select2 select2-hidden-accessible" data-placeholder="Zgjidh autor"
                                style="width: 100%;" tabindex="-1" aria-hidden="true">
                            @foreach($autor as $a)
                                @if($a->autor_id == $libri->id_autor)
                                    <option value="{!! $a->autor_id !!}" selected> {!! $a->emri !!} {!! $a->mbiemri !!} </option>
                                @else
                                    <option value="{!! $a->autor_id !!}" > {!! $a->emri !!} {!! $a->mbiemri !!} </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Zhanri</label>
                        <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="Zgjidh zhaner"
                                style="width: 100%;" tabindex="-1" aria-hidden="true">
                            @foreach($zhanri as $a)
                                @if(in_array($a->libri_id, $zhanriLibrit))
                                    <option value="{!! $a->libri_id !!}" selected> {!! $a->emri !!}</option>
                                @else
                                    <option value="{!! $a->libri_id !!}"> {!! $a->emri !!}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cmimi</label>
                        <input type="number" name="cmimi" class="form-control" placeholder="Cmimi">
                    </div>
                    <div class="form-group">
                        <label>Viti Botimit</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker">
                            </div>
                    </div>
                    <div class="form-group">
                        <label>Shtëpia Botuese</label>
                        <input type="text" name="shtepia" class="form-control" placeholder="Shtëpia botimit">
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto Librit</label>
                        <input type="file" id="foto">

                        <p class="help-block"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $(".select2").select2();

            //Date picker
            $('#datepicker').datepicker({
                autoclose: true
            });
        });
    </script>
@endsection