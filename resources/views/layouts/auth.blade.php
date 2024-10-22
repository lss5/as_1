@extends('layouts.clear')

@section('content')
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('img/logo.png') }}" alt="" width="50" height="50">
            <a href="../../index2.html" class="fs-2 fw-medium ms-1"><b>Asic</b>Seller</a>
        </div>

        @yield('card')
    </div>
@endsection