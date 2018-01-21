@extends('layouts.prime')
@section('pageTitle')
    Dashboard - Autore
@endsection
@section('main_container')
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Lista e autoreve</h3>
            </div>

            <div class="box-body">
                <div class="row">
                    @if(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::ADMIN)
                        <div class="col-sm-2" style="margin-bottom: 16px;">
                            <button class="btn btn-success" id="krijo">
                                <i class="fa fa-plus"></i> Shto
                            </button>
                        </div>
                        <div class="col-sm-6 zhanri_div" style="display: none;">
                            <div class="col-sm-5 form-group">
                                <input type="text" name="emri_autorit" class="form-control" placeholder="emri">
                            </div>
                            <div class="col-sm-5 form-group">
                                <input type="text" name="mbiemri" class="form-control" placeholder="mbiemri">
                            </div>
                            <div class="com-sm-2">
                                <button class="btn btn-success" id="save_autor"><i class="fa fa-save"></i></button>
                            </div>
                            <div class="col-sm-12">
                                <p class="error" style="color: red;"></p>
                            </div>
                        </div>
                    @endif
                </div>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>EMRI</th>
                        <th>MBIEMRI</th>
                        <th>VEPRIME</th>
                    </tr>
                    </thead>

                    <tbody id="autor_table">
                    @foreach($autor as $z)
                        <tr>
                            <td>{!! $z->emri !!}</td>
                            <td>{!! $z->mbiemri !!}</td>
                            <td>
                                <button data-id="{!! $z->autor_id !!}" class="btn btn-danger deleteAutor">
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

                $(".deleteAutor").on('click', function () {
                    fshiAutor(this);
                });

                function fshiAutor(a) {
                    var id = $(a).data("id");
                    var elem = $(a);
                    var url = '{!! \Illuminate\Support\Facades\URL::route('fshiAutor') !!}';

                    swal({
                        title: "A jani te sigurte qe doni ta fshini kete autor?",
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
                                } else if(data.sts ==2 )  {
                                    swal("Autori nuk mund te fshihet!", "Ka ende libra te ketij autori ne biblioteke!", "error");
                                }else {
                                    swal("U anulua!", "Dicka nuk shkoi mire, Autori nuk mund te fshihet!", "error");

                                }
                            }
                        })
                    });
                }

                var tabel = $("#autor_table");
                var div = $(".zhanri_div");

                $("#krijo").click(function () {
                    div.show();
                    $("#save_autor").on("click", function () {
                        saveAutor();
                    })
                });

                function saveAutor() {

                    var emri = $('input[name="emri_autorit"]').val();
                    var mbiemri = $('input[name="mbiemri"]').val();
                    var url = '{!! \Illuminate\Support\Facades\URL::route('saveAutor') !!}';

                    if (emri != '' && mbiemri != '') {
                        $('.error').html('');
                        swal({
                                title: "A je i sigurte?",
                                text: "Ju do te shtoni nje Autor te ri ne tabele",
                                showCancelButton: true,
                                closeOnConfirm: false,
                                showLoaderOnConfirm: true
                            },
                            function () {
                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    data: {_token: '{!! csrf_token() !!}', emri: emri, mbiemri:mbiemri},
                                    success: function (data) {
                                        if (data.sts == 1) {
                                            swal("U shtua!", "", "success");
                                            tabel.append('<tr><td>' + emri + '</td><td>' + mbiemri + '</td><td>' +
                                                '<button data-id="' + data.id + '" ' +
                                                'class="btn btn-danger deleteAutor"><i class="fa fa-trash"></i></button></td></tr>');
//                                        $("#example1").destroy();
//                                        refreshTable();
                                            $('.deleteAutor').off('click');
                                            $('.deleteAutor').on('click', function () {
                                                fshiAutor(this);
                                            });
                                            div.hide();
                                            $('input[name="emri_autorit"]').empty();
                                            $('input[name="mbiemri"]').empty();
                                        } else {
                                            swal("U anulua!", "Dicka nuk shkoi mire, autori nuk u shtua!", "error");
                                        }
                                    }
                                })
                            });
                    }else{
                        $('.error').html('Vendosni emrin dhe mbiemrin e autorit!');
                    }
                }
            });
    </script>
@endsection