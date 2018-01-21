@extends('layouts.prime')
@section('pageTitle')
    Dashboard - Autorë
@endsection
@section('main_container')
    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Autorë</h3>
            </div>

            <div class="box-body">
                <div class="row">
                <div class="col-sm-2" style="margin-bottom: 16px;">
                    <a href="{!! URL::route('krijoAutor') !!}" class="btn btn-success">
                        <i class="fa fa-plus"></i> Krijo
                    </a>
                </div>
                </div>
            <div class="row">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>EMRI</th>
                        <th>MBIEMRI</th>
                        <th>VEPRIME</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($autor as $a)
                        <tr>
                            <td>{!! $a->emri !!}</td>
                            <td>{!! $a->mbiemri !!}</td>
                            <td>
                                <a href="{!! URL::route('shikoAutor', array($a->autor_id)) !!}" class="btn btn-default">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="#" data-id="{!! $a->autor_id !!}" class="btn btn-danger fshi">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
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


            $(".fshi").on("click", function () {
                fshiAutor(this);
            });

            function fshiAutor(a) {
                var id = $(a).data("id");
                var elem = $(a);
                var url = '{!! \Illuminate\Support\Facades\URL::route('fshiAutor') !!}';
                swal({
                    title: "A jeni te sigurt qe doni ta fshini kete Autor?",
                    type: "warning",
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
                            } else {
                                swal("U anulua!", data.error, "error");
                            }
                        }
                    })
                });
            }
        });
    </script>
@endsection