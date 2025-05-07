<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset("image/logo.png") }}" type="image/png">

    <title>
        @yield("title") - YRS
    </title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Noto+Sans+Myanmar:wght@100;200;300;400;500;600;700;800;900&family=Lato:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("plugins/fontawesome-free/css/all.min.css") }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("css/adminlte.min.css") }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset("plugins/overlayScrollbars/css/OverlayScrollbars.min.css") }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset("plugins/daterangepicker/daterangepicker.css") }}">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset("plugins/toastr/toastr.min.css") }}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset("plugins/datatables/datatables.min.css") }}">

    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset("plugins/select2/css/select2.min.css") }}">

    {{-- Viewer --}}
    <link rel="stylesheet" href="{{ asset("plugins/viewer/viewer.min.css") }}">

    {{-- Leaflet --}}
    <link rel="stylesheet" href="{{ asset("plugins/leaflet/leaflet.css") }}">
    <link rel="stylesheet" href="{{ asset("plugins/leaflet-locationpicker/leaflet-locationpicker.css") }}">

    <!-- Scripts -->
    @vite(["resources/sass/app.scss", "resources/js/app.js"])

    @yield('style')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        @include("layouts.preloader")

        <!-- Navbar -->
        @include("layouts.navigation")

        <!-- Main Sidebar Container -->
        @include("layouts.sidebar")

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    @yield("header")
                </div>
            </div>

            <!-- Main content -->
            <section class="content tw-pb-5">
                <div class="container-fluid">
                    @yield("content")
                </div>
            </section>
            <!-- /.content -->
        </div>

        <!-- Footer -->
        @include("layouts.footer")

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

    </div>

    <!-- jQuery -->
    <script src="{{ asset("plugins/jquery/jquery.min.js") }}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset("plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>

    <!-- daterangepicker -->
    <script src="{{ asset("plugins/moment/moment.min.js") }}"></script>
    <script src="{{ asset("plugins/daterangepicker/daterangepicker.js") }}"></script>

    <!-- overlayScrollbars -->
    <script src="{{ asset("plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset("js/adminlte.js") }}"></script>

    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

    <!-- Toastr -->
    <script src="{{ asset("plugins/toastr/toastr.min.js") }}"></script>

    <!-- DataTables -->
    <script src="{{ asset("plugins/datatables/datatables.min.js") }}"></script>

    <!-- Select2 -->
    <script src="{{ asset("plugins/select2/js/select2.min.js") }}"></script>

    {{-- Viewer --}}
    <script src="{{ asset("plugins/viewer/viewer.js") }}"></script>

    {{-- Leaflet --}}
    <script src="{{ asset("plugins/leaflet/leaflet.js") }}"></script>
    <script src="{{ asset("plugins/leaflet-locationpicker/leaflet-locationpicker.js") }}"></script>

    {{-- Repeater --}}
    <script src="{{ asset("plugins/repeater/jquery.repeater.js") }}"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                },
                error: function(res, status, error) {
                    toastr.error(res.responseJSON.message);
                }
            });
            @if(session('success'))
                toastr.success("{{ session('success') }}")
            @endif
            @if(session('error'))
                toastr.error("{{ session('error') }}")
            @endif
        });
    </script>
    @stack("scripts")
</body>

</html>
