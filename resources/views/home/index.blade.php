@extends('home.layout')

@section('content_p')
<div class="row">
    <div class="col-12">
        <h3>{{ Auth::user()->name }}</h3>
    </div>
</div>
@endsection
