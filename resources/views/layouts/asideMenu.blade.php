<ul class="nav navbar-right top-nav">

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {!! \App\Http\Controllers\Utils::getUsername() !!} <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="{!! URL::route('logout') !!}">Logout</a></li>
        </ul>
    </li>
</ul>

<div class=" collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <li class="active">
            <a href="{!! URL::route('dashboard') !!}"><i class="fa fa-fw fa-dashboard"></i> Dashboard </a>
        </li>
        @if(\App\Http\Controllers\Utils::getRole() == \App\Http\Controllers\Classes\LoginClass::ADMIN)
        <li class="">
            <a href="{!! URL::route('listRaporte') !!}"><i class="fa fa-fw fa-line-chart"></i> Raporte </a>
        </li>
        @endif
        <li class="">
            <a href="{!! URL::route('listLibrat') !!}"><i class="fa fa-fw fa-book"></i> Librat </a>
        </li>
        @if(\App\Http\Controllers\Utils::getRole() <= \App\Http\Controllers\Classes\LoginClass::PUNONJES)
        <li class="">
            <a href="{!! URL::route('listKlient') !!}"><i class="fa fa-fw fa-users"></i> Klientët </a>
        </li>
        @endif
        {{--<li class="">--}}
            {{--<a href="{!! URL::route('listUsers') !!}"><i class="fa fa-fw fa-users"></i> Përdoruesit </a>--}}
        {{--</li>--}}
    </ul>

</div>

<script>
    $(document).ready(function(){
        $('.navbar-ex1-collapse li').click(function() {
            $(this).siblings('li').removeClass('active');
            $(this).addClass('active');
        });
    });
</script>
