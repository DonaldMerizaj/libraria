<ul class="nav navbar-right top-nav">

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Admin <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="{!! URL::route('logout') !!}">Logout</a></li>
        </ul>
    </li>
</ul>

<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <li class="active">
            <a href=""><i class="fa fa-fw fa-dashboard"></i> Dashboard </a>
        </li>
        <li class="">
            <a href="{!! URL::route('listRaporte') !!}"><i class="fa fa-fw fa-line-chart"></i> Raporte </a>
        </li>
        <li class="">
            <a href="{!! URL::route('listLibrat') !!}"><i class="fa fa-fw fa-book"></i> Librat </a>
        </li>
        <li class="">
            <a href="{!! URL::route('listKlient') !!}"><i class="fa fa-fw fa-users"></i> Klientët </a>
        </li>
        <li class="">
            <a href="{!! URL::route('listUsers') !!}"><i class="fa fa-fw fa-users"></i> Përdoruesit </a>
        </li>
    </ul>
</div>