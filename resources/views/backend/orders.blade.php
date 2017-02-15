@extends('backend.layouts.master')
@section('main_container')

<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table id="ordersTable" class="table">
                <thead>
                    <tr>
                        <td><b>ID</b></td>
                        <td><b>Emri i klientit</b></td>
                        <td><b>Nr Tel Klientit</b></td>
                        <td><b>EMAIL i Klientit</b></td>
                        <td><b>Adresa e Klientit</b></td>
                        <td><b>Piktura ID</b></td>
                        <td><b>STATUS</b></td>
                        <td><b>ACTION</b></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->client_name}}</td>
                    <td>{{$order->client_phone}}</td>
                    <td>{{$order->client_email}}</td>
                    <td>{{$order->client_address}}</td>
                    <td>{{$order->picture_id}}</td>
                    <td>
                        @if($order->status == 1)
                        <span class="labal label-success">Aprovuar</span>
                        @else
                        <span class="label label-warning">Ne pritje</span>
                        @endif
                    </td>
                    <td>
                        <a order_id="{{ $order->id }}" id="approve_order" class="btn btn-sm btn-primary">Approve</a>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    

      run();

    
    function run() {
      // send csrf token on every ajax request
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      
      
      
      // approve order
    
    $(document).on('click', '#approve_order', function(event) {
      event.preventDefault();
      debugger;
      
      var order_id = $(this).attr('order_id');
    
    
      $.ajax({
        url: '/approve-order',
        method: 'POST',
        data: {
          order_id: order_id,
        },
        success: function(res) {
          debugger;
          if (res.message == 'OK') {
            swal({
              title: 'OK',
              text: 'Order approved successfully.',
              type: 'success'
            })
            
            window.location.href = "https://artrev-gertasinani.c9users.io/admin/orders";
          }
          else {
            $('#overlay').addClass('hidden');
            swal({
              title: 'Error',
              text: res.result,
              type: 'error'
            });
          }
          $('#overlay').addClass('hidden');
        }
      });
    });
      
    }
    
</script>


@stop