
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Libraria</title>

    <!-- Bootstrap Core CSS -->
    <link href="{!! asset('/assets/css/bootstrap.css') !!}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{!! asset('/assets/css/sb-admin.css') !!}" rel="stylesheet">

    <!-- Morris Charts CSS -->

    <!-- Custom Fonts -->
    <link href="{!! asset('/assets/css/font-awesome.min.css') !!}" rel="stylesheet" type="text/css">
    <!-- Sweetalert -->
    <link rel="stylesheet" href="{!! asset('/assets/bower_components/sweetalert/dist/sweetalert.css') !!}">
    <!-- Loaders Css -->
    <link rel="stylesheet" href="{!! asset('/assets/bower_components/loaders.css/loaders.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('/assets/bower_components/chosen/chosen.css') !!}">


    <!-- jQuery -->
    <script src="{!! asset('/assets/js/jquery.js') !!}"></script>
    <!-- Sweetalert -->
    <script src="{!! asset('/assets/bower_components/sweetalert/dist/sweetalert.min.js') !!}"></script>
    <script src="{!! asset('/assets/bower_components/chosen/chosen.jquery.js') !!}" ></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body style="background-color: #ffffff !important;">

<div id="wrapper">

    <style>

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #000;
            filter:alpha(opacity=50);
            -moz-opacity:0.5;
            -khtml-opacity: 0.5;
            opacity: 0.5;
            z-index: 10000;
        }

        .loader-inner.ball-pulse {
            position: absolute;
            left: 50%;
            top: 50%;
            color: white;
        }
    </style>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">

            {{--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">--}}
                {{--<span class="sr-only">Toggle navigation</span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
            {{--</button>--}}
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <a class="navbar-brand" href="/">Libraria</a>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
        <!-- Top Menu Items -->

        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">
            <div id="overlay" class="hidden">
                <div class="loader-inner ball-pulse"><div></div><div></div><div></div></div>
            </div>
            <!-- Page Heading -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Mirësevini</h3>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                            <div class="box-body">
                                {!! Form::open(array('id'=>'loginForm', 'route'=>'login', 'method'=>'post')) !!}

                                <div class="row">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 16px;">
                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                                        <div class="col-sm-10">
                                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                    </div>
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right">Hyr</button>
                            </div>
                           {!! Form::close() !!}

                    </div>
                </div>

            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->



<!-- Bootstrap Core JavaScript -->
<script src="{!! asset('/assets/js/bootstrap.min.js')!!}"></script>

<!-- Morris Charts JavaScript -->
<script src="{!! asset('/assets/js/plugins/morris/raphael.min.js') !!}"></script>
<script src="{!! asset('/assets/js/plugins/morris/morris.min.js') !!}"></script>
<script src="{!! asset('/assets/js/plugins/morris/rmorris-data.js') !!}"></script>

</body>

</html>

