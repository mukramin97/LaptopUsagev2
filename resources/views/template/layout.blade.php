<!-- layout.blade.php -->
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">



    {{-- <link rel="stylesheet" href="{{ asset('DataTables/datatables.min.css') }}"> --}}

    {{-- <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}" > --}}

    {{-- CDN Bootstrap
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}

    <style type="text/css">
        .divider {
            width: 100%;
            height: 1px;
            background: #BBB;
            margin: 1rem 0;
        }
    </style>

    <title>Aplikasi</title>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>

            </ul>

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link text-center">
                <span class="brand-text font-weight-light">Laptop Usage v2</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img alt="Avatar" class="table-avatar img-circle"
                            src="{{ asset('AdminLTE/dist/img/avatar5.png') }}">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Hi, {{ Auth::user()->name }}!</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                  with font-awesome or any other icon font library -->

                        <li class="nav-header font-weight-bold">MENU PENGGUNAAN LAPTOP</li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }} "
                                href="{{ route('dashboard.index') }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('penggunaan.index') ? 'active' : '' }} "
                                href="{{ route('penggunaan.index') }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Penggunaan Laptop
                                </p>
                            </a>
                        </li>

                        <li class="nav-header font-weight-bold">MENU PERPUSTAKAAN</li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('perpustakaan.index') ? 'active' : '' }} "
                                href="{{ route('perpustakaan.index') }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('perpustakaanData') ? 'active' : '' }} "
                                href="{{ route('perpustakaanData') }}">
                                <i class="nav-icon fas fa-book-reader"></i>
                                <p>
                                    Perpustakaan
                                </p>
                            </a>
                        </li>

                        <li class="nav-header font-weight-bold">SETTINGS</li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('siswa.index') ? 'active' : '' }}"
                                href="{{ route('siswa.index') }}">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>
                                    Siswa
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('kelas.index') ? 'active' : '' }} "
                                href="{{ route('kelas.index') }}">
                                <i class="nav-icon fas fa-address-book"></i>
                                <p>
                                    Kelas
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">

                <div class="content">
                    <main class="py-4">
                        <div class="container-fluid">
                            @yield('content')
                        </div>
                    </main>
                </div>

            </div>
            <!-- /.content-header -->


        </div>
        <!-- /.content-wrapper -->


        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Made with <i class="fa fa-heart" style="color: red"></i> by Mukramin
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- @include('sweetalert::alert') --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> --}}

    <script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>



    {{-- <script src="{{ asset('DataTables/datatables.min.js') }}"></script> --}}



</body>

</html>
