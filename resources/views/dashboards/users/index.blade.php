@extends('dashboards.users.layouts.user-dash-layout')
@section('title','Dashboard')
@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- JQVMap -->
        <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
        <!-- summernote -->
        <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

         <!-- jQuery -->
         <script src="plugins/jquery/jquery.min.js"></script>
         <!-- jQuery UI 1.11.4 -->
         <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
 
         <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
         <script>
             $.widget.bridge('uibutton', $.ui.button)
         </script>
         <!-- Bootstrap 4 -->
         <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
         <!-- ChartJS -->
         <script src="plugins/chart.js/Chart.min.js"></script>
         <!-- Sparkline -->
         <script src="plugins/sparklines/sparkline.js"></script>
         <!-- JQVMap -->
         <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
         <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
         <!-- jQuery Knob Chart -->
         <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
         <!-- daterangepicker -->
         <script src="plugins/moment/moment.min.js"></script>
         <script src="plugins/daterangepicker/daterangepicker.js"></script>
         <!-- Tempusdominus Bootstrap 4 -->
         <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
         <!-- Summernote -->
         <script src="plugins/summernote/summernote-bs4.min.js"></script>
 
         <!-- overlayScrollbars -->
         <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
         <!-- AdminLTE App -->
         <script src="dist/js/adminlte.js"></script>
         <!-- AdminLTE for demo purposes -->
         <script src="dist/js/demo.js"></script>
         <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
         <script src="dashboard.js"></script>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

            <!-- Preloader -->
            <!-- /.navbar -->
            <!-- Content Wrapper. Contains page content -->

            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    @php
                                        
                                        $products = DB::table('products')
                                            ->select()
                                            ->get();
                                    @endphp
                                    <h3>@php
                                        echo $products->count();
                                    @endphp</h3>

                                    <p>All Products</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="{{route('product.index')}}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    @php
                                        
                                        $suppliers = DB::table('suppliers')
                                            ->select()
                                            ->get();
                                    @endphp
                                    <h3>@php
                                        echo $suppliers->count();
                                    @endphp</h3>

                                    <p>Supplier</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="{{route('supplier.index')}}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    @php
                                        
                                        $pr = DB::table('pr')
                                            ->select()
                                            ->get();
                                    @endphp
                                    <h3>@php
                                        echo $pr->count();
                                    @endphp</h3>

                                    <p>Purchaing Requestion</p>
                                </div>
                                <div class="icon">
                                    <i class="ion-stats-bars"></i>
                                </div>
                                <a href="{{route('user.pr')}}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    @php
                                        
                                        $po_details = DB::table('po_details')
                                            ->select()
                                            ->get();
                                    @endphp
                                    <h3>@php
                                        echo $po_details->count();
                                    @endphp</h3>


                                    <p>Purchaing order</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="{{route('user.po')}}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                        <!-- ./col -->
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->

       
    </body>

    </html>




@endsection
