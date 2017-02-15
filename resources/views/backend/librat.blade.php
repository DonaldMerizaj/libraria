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
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    {{--<div class="row">--}}
                        {{--<div class="col-sm-6">--}}
                            {{--<div class="dataTables_length" id="example1_length"><label>Show--}}
                                    {{--<select name="example1_length" aria-controls="example1" class="form-control input-sm">--}}
                                        {{--<option value="10">10</option><option value="25">25</option>--}}
                                        {{--<option value="50">50</option><option value="100">100</option>--}}
                                    {{--</select> entries</label></div>--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-6">--}}
                            {{--<div id="example1_filter" class="dataTables_filter">--}}
                                {{--<label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="example1">--}}
                                {{--</label></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="row" style="padding-right: 0px; padding-left: 0px; margin-left: 0px; margin-right: 0px;">

                        <div class="col-sm-11">
                            <table id="libratTable" class="table table-bordered table-striped dataTable">
                                <thead>
                                <tr role="row">
                                    <th>Rendering engine</th>
                                    <th>Browser</th>
                                    <th>Platform(s)</th>
                                    <th>Engine version</th>
                                    <th>CSS grade</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr >
                                    <td >Other browsers</td>
                                    <td>All others</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>U</td>
                                </tr><tr  >
                                    <td >Trident</td>
                                    <td >AOL browser (AOL desktop)</td>
                                    <td>Win XP</td>
                                    <td>6</td>
                                    <td>A</td>
                                </tr><tr >
                                    <td >Gecko</td>
                                    <td >Camino 1.0</td>
                                    <td>OSX.2+</td>
                                    <td>1.8</td>
                                    <td>A</td>
                                </tr><tr>
                                    <td >Gecko</td>
                                    <td >Camino 1.5</td>
                                    <td>OSX.3+</td>
                                    <td>1.8</td>
                                    <td>A</td>
                                </tr><tr role="row" class="odd">
                                    <td class="">Misc</td>
                                    <td class="sorting_1">Dillo 0.8</td>
                                    <td>Embedded devices</td>
                                    <td>-</td>
                                    <td>X</td>
                                </tr><tr role="row" class="even">
                                    <td class="">Gecko</td>
                                    <td class="sorting_1">Epiphany 2.20</td>
                                    <td>Gnome</td>
                                    <td>1.8</td>
                                    <td>A</td>
                                </tr><tr role="row" class="odd">
                                    <td class="">Gecko</td>
                                    <td class="sorting_1">Firefox 1.0</td>
                                    <td>Win 98+ / OSX.2+</td>
                                    <td>1.7</td>
                                    <td>A</td>
                                </tr><tr role="row" class="even">
                                    <td class="">Gecko</td>
                                    <td class="sorting_1">Firefox 1.5</td>
                                    <td>Win 98+ / OSX.2+</td>
                                    <td>1.8</td>
                                    <td>A</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td class="">Gecko</td>
                                    <td class="sorting_1">Firefox 2.0</td>
                                    <td>Win 98+ / OSX.2+</td>
                                    <td>1.8</td>
                                    <td>A</td>
                                </tr>
                                <tr role="row" class="even">
                                    <td class="">Gecko</td>
                                    <td class="sorting_1">Firefox 3.0</td>
                                    <td>Win 2k+ / OSX.3+</td>
                                    <td>1.9</td>
                                    <td>A</td>
                                </tr></tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    {{--<div class="row">--}}
                        {{--<div class="col-sm-5">--}}
                            {{--<div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-7">--}}
                            {{--<div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">--}}
                                {{--<ul class="pagination"><li class="paginate_button previous disabled" id="example1_previous">--}}
                                        {{--<a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0">Previous</a></li>--}}
                                    {{--<li class="paginate_button active"><a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0">1</a></li>--}}
                                    {{--<li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="2" tabindex="0">2</a></li>--}}
                                    {{--<li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="3" tabindex="0">3</a></li>--}}
                                    {{--<li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="4" tabindex="0">4</a></li>--}}
                                    {{--<li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="5" tabindex="0">5</a></li>--}}
                                    {{--<li class="paginate_button "><a href="#" aria-controls="example1" data-dt-idx="6" tabindex="0">6</a></li>--}}
                                    {{--<li class="paginate_button next" id="example1_next"><a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0">Next</a>--}}
                                    {{--</li></ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>

        </div>
    </div>
@endsection