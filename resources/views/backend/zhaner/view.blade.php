@extends('layouts.prime')
@section('pageTitle')
    Dashboard - Zhaner
@endsection
@section('main_container')
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Zhanerat e librave</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    @if(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::ADMIN)
                        <div class="col-sm-2" style="margin-bottom: 16px;">
                            <button class="btn btn-success" id="krijo">
                                <i class="fa fa-plus"></i> Krijo
                            </button>
                        </div>
                        <div class="col-sm-6 zhanri_div" style="display: none;">
                            <div class="col-sm-6 form-group">
                                <input type="text" name="emri_zhanrit" class="form-control" placeholder="emri">
                            </div>
                            <div class="com-sm-6">
                                <button class="btn btn-success" id="save_zhaner"><i class="fa fa-save"></i></button>
                            </div>
                        </div>
                    @endif
                </div>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ZHANRI</th>
                        <th>VEPRIME</th>
                    </tr>
                    </thead>

                    <tbody id="zhaner_table">
                    @foreach($zhanri as $z)
                        <tr>
                            <td>{!! $z->emri !!}</td>
                            <td>
                                {{--<a href="{!! URL::route('editZhanri', array($z->zhanri_id)) !!}" class="btn btn-default">--}}
                                {{--<i class="fa fa-pencil"></i>--}}
                                {{--</a>--}}
                                <button data-id="{!! $z->zhanri_id !!}" class="btn btn-danger deleteZhaner">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(
            function () {

                refreshTable();

                function refreshTable() {

                    $('#example1').DataTable({
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false
                    });
                }

                $(".deleteZhaner").on('click', function () {
                    fshiZhaner(this);
                });

                function fshiZhaner(a) {
                    var id = $(a).data("id");
                    var elem = $(a);
                    var url = '{!! \Illuminate\Support\Facades\URL::route('fshiZhaner') !!}';

                    swal({
                        title: "A jani te sigurte qe doni ta fshini kete zhaner?",
                        type: "info",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    }, function () {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {_token: '{!! csrf_token() !!}', id: id},
                            success: function (data) {
                                if (data.sts == 1) {
                                    swal("U fshi!", "", "success");
                                    elem.parent().parent().remove();
                                } else if (data.sts == 2) {
                                    swal("U anulua!", "Zhaneri nuk mund te fshihet pasi ka libra qe i perkasin!", "error");

                                } else {
                                    swal("U anulua!", "Dicka nuk shkoi mire, zhaneri nuk mund te fshihet!", "error");
                                }
                            }
                        })
                    });
                }

                var tabel = $("#zhaner_table");
                var div = $(".zhanri_div");

                $("#krijo").click(function () {
                    div.show();
                    $("#save_zhaner").on("click", function () {
                        saveZhaner();
                    })
                });

                function saveZhaner() {

                    var emri = $('input[name="emri_zhanrit"]').val();
                    var url = '{!! \Illuminate\Support\Facades\URL::route('save_zhaner') !!}';

                    if (emri != '') {
                        swal({
                                title: "A je i sigurte?",
                                text: "Ju do te shtoni nje Zhaner te ri ne tabele",
                                showCancelButton: true,
                                closeOnConfirm: false,
                                showLoaderOnConfirm: true
                            },
                            function () {
                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    data: {_token: '{!! csrf_token() !!}', emri: emri},
                                    success: function (data) {
                                        if (data.sts == 1) {
                                            swal("U shtua!", "", "success");
                                            tabel.append('<tr><td>' + emri + '</td><td><button data-id="' + data.id + '" ' +
                                                'class="btn btn-danger deleteZhaner"><i class="fa fa-trash"></i></button></td></tr>');
//                                        $("#example1").destroy();
//                                        refreshTable();
                                            $('.deleteZhaner').off('click');
                                            $('.deleteZhaner').on('click', function () {
                                                fshiZhaner(this);
                                            });
                                            div.hide();
                                            $('input[name="emri_zhanrit"]').empty();
                                        } else {
                                            swal("U anulua!", "Dicka nuk shkoi mire, zhaneri nuk u shtua!", "error");
                                        }
                                    }
                                })
                            });
                    }
                }
            });
    </script>
@endsection