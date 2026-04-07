<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
   <!-- All Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="DexignLab" >
    <meta name="robots" content="" >
    <meta name="keywords" content="" >
    <meta name="description" content="" >
    <meta property="og:title" content="" >
    <meta property="og:description" content="">
    <meta property="og:image" content="social-image.png" >
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Page Title Here -->
    <title>Rshrini - Login Panel</title>

<!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/favicon.png')}}" >
    <link href="{{asset('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

</head>

<body class="body  h-100">
    <div class="authincation d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="login-aside text-center  d-flex flex-column flex-row-auto">
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <div class="text-center mb-lg-4 mb-2 pt-5 logo">
                    <!--<img src="{{asset('assets/images/logo-white.png')}}" alt="">-->
                </div>
                <h3 class="mb-2 text-white">Welcome back!</h3>
                <p class="mb-4">User Experience & Interface Design <br>Strategy SaaS Solutions</p>
            </div>
            <div class="aside-image position-relative" style="background-image:url({{asset('assets/images/background/pic-2.png')}});">
                <img class="img1 move-1" src="{{asset('assets/images/background/pic3.png')}}" alt="">
                <img class="img2 move-2" src="{{asset('assets/images/background/pic4.png')}}" alt="">
                <img class="img3 move-3" src="{{asset('assets/images/background/pic5.png')}}" alt="">
                
            </div>
        </div>
        <div class="container flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <div class="d-flex justify-content-center h-100 align-items-center">
                <div class="authincation-content style-2">
                    <div class="row no-gutters">
                        <div class="col-xl-12 tab-content">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{asset('assets/vendor/global/global.min.js')}}"></script>
    <script src="{{asset('assets/js/custom.min.js')}}"></script>
    <script src="{{asset('assets/js/dlabnav-init.js')}}"></script>
    
</body>
</html>
