<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8" />
    <title>Aam Play</title>
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
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center shadow-lg">
                        <img src="{{ secure_asset('assets/images/logo-sm.png') }}" class="rounded-3" width="80">
                        <h2 class="mt-2 text-danger">Welcome to Aam Play</h2>
                        <div class="d-flex justify-content-evenly align-items-center">
                            @if (Route::has('login'))
                                @auth
                                    @if(Auth::user()->role == 'ADMIN')
                                        <a href="{{ url('/dashboard') }}" class="btn btn-danger shadow-lg">Dashboard</a>
                                    @else
                                        <a href="{{ url('/home') }}" class="btn btn-danger shadow-lg">Home</a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-danger shadow-lg">Log in</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-danger shadow-lg">Register</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ secure_asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ secure_asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/pages/sweet-alert.init.js') }}"></script>
</body>
</html>