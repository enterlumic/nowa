<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Meta Data -->
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
        <meta name="Author" content="Spruko Technologies Private Limited">
        <meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

        <!-- Favicon -->
        <link rel="icon" href="../assets/images/brand-logos/favicon.ico" type="image/x-icon">

        <!-- Main Theme Js -->
        <script src="../assets/js/authentication-main.js"></script>

        <!-- Bootstrap Css -->
        <link id="style" href="../assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet" >

        <!-- Style Css -->
        <link href="../assets/css/styles.min.css" rel="stylesheet" >

        <!-- Icons Css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" >

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="error-page1 bg-primary">
        {{ $slot }}

    <!-- Custom-Switcher JS -->
    <script src="../assets/js/custom-switcher.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Show Password JS -->
    <script src="../assets/js/show-password.js"></script>

    </body>
</html>
