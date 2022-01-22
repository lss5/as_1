@extends('layouts.app')

@section('content')
<div class="container shadow-sm bg-white rounded py-3">
    <div class="row">
        <div class="col-md-2">
            @include('partials.home_menu')
        </div>
        <div class="col-md-10">
            @yield('content_p')
        </div>
    </div>
</div>
@endsection