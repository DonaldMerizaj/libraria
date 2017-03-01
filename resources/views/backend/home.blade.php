@extends('layouts.prime')
@section('pageTitle')
    Dashboard
@endsection
@section('main_container')
    <div class="row">
        <div class="col-sm-12">
            <h1>Welcome <b>{!! $username !!}</b></h1>
        </div>
    </div>
    <hr>
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
@endsection