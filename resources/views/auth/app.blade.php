<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{asset('/assets/images/logos/logo.png')}}">

    <title>Elma | @yield('title')
    </title>

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@500&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('/assets/css/material-dashboard.css?v=3.0.2')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('/assets/css/custom.css')}}">
</head>

<body>
    <main class="main-content">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url({{ asset('/assets/images/shipping.png')}});">
            <div class="container my-auto">
                <div class="row">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-5 col-xl-4 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3">
                                <div class="bg-gradient-info shadow-info border-radius-lg py-3 pe-1">
                                    <h4 class="text-dark font-weight-bolder text-center my-2">@yield('title')</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('layouts._flash')

                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>