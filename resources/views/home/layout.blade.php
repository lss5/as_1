@extends('layouts.app')

@section('content')
<div class="container shadow-sm bg-white rounded my-2 py-2">
    <div class="row">
        <div class="col-md-12 my-2">
            @include('partials.home_menu')
        </div>
        {{-- <div class="col-md-12 my-2"> --}}
        @include('partials.alerts')
        {{-- </div> --}}
        <div class="col-md-12 my-2">
            @yield('content_p')
        </div>
    </div>
</div>
@endsection
