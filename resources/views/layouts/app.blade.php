<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Elma | @yield('title')</title>

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@500&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('/assets/css/material-dashboard.css')}}" rel="stylesheet" />

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="{{asset('assets/js/slim.min.js')}}"></script>
    <script src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

    <script src="{{asset('assets/js/jquery-3.1.1.min.js')}}"></script>

    {{-- jquery confirm --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    {{-- charts --}}
    <script src="{{asset('assets/js/chart.min.js')}}"></script>

    <link rel="stylesheet" href="{{asset('/assets/css/custom.css')}}">

    <!-- Inputmask library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

    {{-- select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- Typeahead --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"
        integrity="sha512-qOBWNAMfkz+vXXgbh0Wz7qYSLZp6c14R0bZeVX2TdQxWpuKr6yHjBIM69fcF8Ve4GUX6B6AKRQJqiiAmwvmUmQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/bloodhound.min.js"
        integrity="sha512-kC/4GX7MxhslxDVyJOuyMVjr0uc3c/qp9S/E2ORxkttE07pdeImi5LhdRc5aX6sxnhFuRW/tQrRMjTlxZYC8SQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.jquery.min.js"
        integrity="sha512-AnBkpfpJIa1dhcAiiNTK3JzC3yrbox4pRdrpw+HAI3+rIcfNGFbVXWNJI0Oo7kGPb8/FG+CMSG8oADnfIbYLHw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="g-sidenav-show bg-gray-200 custom-scroller">
    @include('layouts._sidebar')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('layouts._header')

        @include('layouts._navbar')

        @include('layouts._flash')

        @yield('content')
    </main>

    @include('layouts._sidedrawer')

    <!--   Core JS Files   -->
    <script src="{{asset('assets/js/material-dashboard.js')}}"></script>
    <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>

    {{-- Preview --}}
    <script src="{{asset('assets/js/preview.js')}}"></script>

    {{-- Sweet Alert --}}
    <script src="{{asset('assets/js/sweetalert.min.js')}}"></script>

    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>