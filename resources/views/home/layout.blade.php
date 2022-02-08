@extends('layouts.app')

@section('content')
<div class="container shadow-sm bg-white rounded my-3 py-3">
    <div class="row my-2">
        <div class="col-md-2">
            @include('partials.home_menu')
        </div>
        <div class="col-md-10">
            @yield('content_p')
        </div>
    </div>
</div>
@endsection
