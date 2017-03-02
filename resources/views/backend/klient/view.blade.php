@extends('layouts.prime')
@section('pageTitle')
    Dashboard - Libri - Kthe
@endsection
@section('main_container')

    <div class="row">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Kthe librin</h3>
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
                        <div class="form-group">
                            <label>Emri Mbiemri</label>
                            <h4>{!! $klienti->emri !!} {!! $klienti->mbiemri !!}</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h4 style="margin-left: 24px;"> Librat e huazuar nga klienti</h4>
                    <div class="col-md-6">
                        <ul style="list-style: none;">
                            @foreach($librat as $l)

                                <li>
                                        @if( date('d/M/Y', strtotime($l->data_dorezimit)) < date('d/m/Y'))
                                    <h4 style="background-color: #FF7043; width: 80%;">
                                        @else
                                            <h4>
                                                @endif
                                                " {!! $l->titulli !!} " - {!! $l->emri !!} {!! $l->mbiemri !!} ____ Afati i kthimit: {!! date('d/M/Y', strtotime($l->data_dorezimit)) !!}</h4>
                                    <button data-id="{!! $l->huazim_id !!}" class="kthe btn btn-info"><i class="fa fa-refresh"></i> Kthe librin</button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('.kthe').click(function () {
                var a = $(this);
                var id = { id: $(a).data('id')};
                $.ajax({
                    type: 'POST',
                    url: '/dashboard/klient/shiko/kthe',
                    data: id ,
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function (data) {
                        if (data.status == 1){
                            $(a).html('<i class="fa fa-check"></i> Kthyer');
                            swal('Sukses', data.data, 'success')
                            $(a).off('click');
                        }else{
                            swal('Kujdes', data.error, 'warning')
                        }
                    }
                })
            })
        });
    </script>
@endsection