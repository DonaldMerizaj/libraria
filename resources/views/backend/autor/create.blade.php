@extends('layouts.prime')
@section('pageTitle')
    Dashboard - Autor - Krijo
@endsection
@section('main_container')
    <div class="row">
        <div class="box">
            <div class="box-header">
                <div style="background-color:#f5f5f5 !important; height: 60px;">
                    <h3 class="box-title" style="margin-top: 0px;">Krijo autor</h3>
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
            {!! Form::open(array('route' => 'ruajAutor', 'id'=>'krijoAutor', 'method'=>'post', 'files'=>true)) !!}
            <div class="col-md-6">
                <div class="form-group">
                    <label>Emri</label>
                    <input type="text" name="emri" value="{!! old('emri') !!}" class="form-control" placeholder="emri">
                    <span class="validate-error"></span>
                </div>

                <div class="form-group">
                    <label>Mbiemri</label>
                    <input type="text" name="mbiemri" value="{!! old('mbiemri') !!}" class="form-control" placeholder="mbiemri">
                    <span class="validate-error"></span>
                </div>


            <div class="row">
                <div class="col-sm-12" style="text-align: right">
                    <button type="button" id="krijo" class="btn btn-success">Krijo</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        </div>
    </div>

    <script>
        $(function () {
            $('#krijoAutor').validate({
                rules: {
                    emri: 'required',
                    mbiemri: 'required'
                },
                messages: {
                    emri: 'Vendosni emrin',
                    mbiemri: 'Vendosni mbiemrin'
                },
                errorPlacement: function (error, element) {
                    $.each(element, function () {
                        $(element).parent().find(".validate-error").html(error);
                    })
                }
            });

            $("#krijo").click(function () {
                $("#krijoAutor").submit();
            });
        })
    </script>
@endsection