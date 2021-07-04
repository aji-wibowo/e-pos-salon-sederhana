<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $title }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('/') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ url('/') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ url('/') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ url('/') }}/plugins/jqvmap/jqvmap.min.css">
    {{-- sweet alert css --}}
    <link rel="stylesheet" href="{{ url('/') }}/css/sweetalert2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/') }}/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ url('/') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ url('/') }}/plugins/daterangepicker/daterangepicker.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ url('/') }}/dist/css/bootstrap-datepicker.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ url('/') }}/plugins/summernote/summernote-bs4.min.css">
    <!-- datatables -->
    <link rel="stylesheet" href="{{ url('/') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('/') }}/dist/css/style.css">
    <!-- jQuery -->
    <script src="{{ url('/') }}/plugins/jquery/jquery.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper" style="background-color: #f4f6f9">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ url('/') }}/dist/img/AdminLTELogo.png" alt="AdminLTELogo"
                height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{ url('/') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">E-SALON</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ url('/') }}/dist/img/user.jpeg" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{ Auth::user()->role == 'pengunjung' ? url('/pengunjung/profil') : '#' }}"
                            class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        @if (Auth::user()->level == 'owner')
                            <li class="nav-item">
                                <a href="{{ url('/owner/master/user') }}" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Master User
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/owner/master/customer') }}" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Master Customer
                                    </p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ url('/owner/master/treatment') }}" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Master Treatment
                                    </p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="{{ url('/owner/master/product') }}" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Master Produk
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/owner/master/account') }}" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Master Account
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/owner/transaction') }}" class="nav-link">
                                    <i class="nav-icon fas fa-credit-card"></i>
                                    <p>
                                        Transaction
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/owner/transaction/jurnal') }}" class="nav-link">
                                    <i class="nav-icon fas fa-book"></i>
                                    <p>
                                        Transaksi Jurnal
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('transaction_report_view') }}" class="nav-link">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>
                                        Laporan Transaksi
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/profil') }}" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Profile
                                    </p>
                                </a>
                            </li>
                        @elseif(Auth::user()->level == 'kasir')
                            <li class="nav-item">
                                <a href="{{ url('/kasir/master/product') }}" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Master Produk
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/kasir/master/customer') }}" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>
                                        Master Customer
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/kasir/transaction') }}" class="nav-link">
                                    <i class="nav-icon fas fa-credit-card"></i>
                                    <p>
                                        Transaksi
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/profil') }}" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Profile
                                    </p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-door-open"></i>
                                <p>Keluar</p>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content" style="padding: 20px; background-color: white; margin: 10px;">
                @yield('content')
            </section>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2021 <a href="http://sun-software.com">SunSoftware</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ url('/') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('/') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Datatable -->
    <script src="{{ url('/') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ url('/') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <!-- ChartJS -->
    <script src="{{ url('/') }}/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="{{ url('/') }}/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="{{ url('/') }}/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="{{ url('/') }}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ url('/') }}/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="{{ url('/') }}/plugins/moment/moment.min.js"></script>
    <script src="{{ url('/') }}/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="{{ url('/') }}/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ url('/') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="{{ url('/') }}/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ url('/') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    {{-- sweet alert js --}}
    <script src="{{ url('/') }}/js/sweetalert2.all.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('/') }}/dist/js/adminlte.js"></script>

    <script>
        $(document).ready(function() {
            var url = window.location;
            $('ul.nav a').filter(function() {
                return this.href == url;
            }).siblings().removeClass('active').end().addClass('active');
            $('ul.treeview-menu a').filter(function() {
                    return this.href == url;
                }).parentsUntil(".nav > .treeview-menu").siblings().removeClass('active menu-open').end()
                .addClass('active menu-open');

            var sMessage = '{{ Session::has('sweetAlertMessage') }}';
            if (sMessage == '1') {
                Swal.fire({
                    icon: '{{ Session::has('sweetAlertMessage') ? Session::get('sweetAlertMessage')['icon'] : '' }}',
                    title: '{{ Session::has('sweetAlertMessage') ? Session::get('sweetAlertMessage')['title'] : '' }}',
                    text: '{{ Session::has('sweetAlertMessage') ? Session::get('sweetAlertMessage')['text'] : '' }}'
                })
            }

            var sValidationMessage = '{{ $errors->any() }}';

            if (sValidationMessage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Maaf, Gagal!',
                    text: 'Mohon input form dengan benar!'
                })
            }
        });
    </script>
</body>

</html>
