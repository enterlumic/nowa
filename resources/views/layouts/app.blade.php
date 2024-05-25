<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
        <meta name="Author" content="Spruko Technologies Private Limited">
        <meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">
        <!-- Favicon -->
        <link rel="icon" href="assets/images/brand-logos/favicon.ico" type="image/x-icon">
        <!-- Choices JS -->
        <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
        <!-- Main Theme Js -->
        <script src="assets/js/main.js"></script>
        <!-- Bootstrap Css -->
        <link id="style" href="assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" >
        <!-- Style Css -->
        <link href="assets/css/styles.min.css" rel="stylesheet" >
        <!-- Icons Css -->
        <link href="assets/css/icons.css" rel="stylesheet" >
        <!-- Node Waves Css -->
        <link href="assets/libs/node-waves/waves.min.css" rel="stylesheet" >
        <!-- Simplebar Css -->
        <link href="assets/libs/simplebar/simplebar.min.css" rel="stylesheet" >
        <!-- Color Picker Css -->
        <link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css">
        <link rel="stylesheet" href="assets/libs/@simonwep/pickr/themes/nano.min.css">
        <!-- Choices Css -->
        <link rel="stylesheet" href="assets/libs/choices.js/public/assets/styles/choices.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- //////////////////////////////////////////////////////////////////////////////////// -->
        <!-- //////////////////////////////////////////////////////////////////////////////////// -->
        <script src="assets/js/core_js/jquery-3.6.0.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <!-- flatpickr js -->
        <script src="assets/js/core_js/flatpickr.min.js?{{ rand() }}"></script>
        <script src="assets/js/core_js/es.js"></script>
        <link href="assets/js/core_js/flatpickr.css" rel="stylesheet" type="text/css" />
        <!-- Noty -->
        <script src="assets/js/core_js/noty.min.js"></script>
        <link rel="stylesheet" href="//cdn.rawgit.com/needim/noty/77268c46/lib/noty.css">
        <!-- Datatables -->
        <link href="assets/js/core_js/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/js/core_js/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/js/core_js/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />     
        <link href="assets/js/core_js/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/js/core_js/select.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/js/core_js/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/js/core_js/select.dataTables.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive Table css -->
        <link href="assets/js/core_js/admin-resources/rwd-table/rwd-table.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/js/core_js/datatable-fixed.css" rel="stylesheet" type="text/css" />
        <!-- Validate js -->
        <script src="assets/js/core_js/jquery.validate.js?{{ rand() }}"></script>
        <script src="assets/js/core_js/bootstrap-notify.min.js"></script>
        <!-- Cargando en formularios-->
        <script src="assets/js/core_js/waitMe.js"></script>
        <link href="assets/js/core_js/waitMe.css?{{ rand() }}" rel="stylesheet" type="text/css" />
        <link href="assets/js/core_js/core.css?{{ rand() }}" rel="stylesheet" type="text/css" />
        <!-- Sweet Alert-->
        <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        <!-- Sweet Alerts js -->
        <script src="assets/js/core_js/sweetalert2.min.js"></script>
        <!-- choices css -->
        <link href="assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
        <!-- choices js -->
        <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
        <!-- Libretia General-->
        <script src="assets/js/core_js/Libreria-General.js?{{ rand() }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @include('layouts.header')
            <!-- main-content -->
            <div class="main-content app-content">
                <!-- container -->
                <div class="main-container container-fluid">
                    <main>
                        {{ $slot }}
                    </main>
                </div>
                <!-- Container closed -->
            </div>
            <!-- main-content closed -->
        @include('layouts.footer')
    </body>
</html>
