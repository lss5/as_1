@extends('layouts.app')

@section('content')
<div class="container shadow-sm bg-white rounded my-3 py-3">
    <div class="row">
        <div class="col-md-12 col-lg-2 my-2">
            @include('partials.home_menu')
        </div>
        <div class="col-md-12 col-lg-10 my-2">
            @yield('content_p')
        </div>
    </div>
</div>
@endsection
