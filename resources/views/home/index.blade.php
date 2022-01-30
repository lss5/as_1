@extends('home.layout')

@section('content_p')
<div class="row">
    <div class="col-12">
        <h3>{{ Auth::user()->name }}</h3>
        <h4>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h4>
        <h4>Country: {{ Auth::user()->country->name }}</h4>
    </div>
</div>
@endsection
