<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ secure_asset('assets/images/favicon.ico') }}">
    
    <link href="{{ secure_asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ secure_asset('assets/libs/animate.css/animate.min.css') }}" rel="stylesheet" type="text/css">

    <!-- App css -->
    <link href="{{ secure_asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ secure_asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ secure_asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ secure_asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <script>
        var baseUrl = "{{ config('app.url') }}";
    </script>
</head>

<body>