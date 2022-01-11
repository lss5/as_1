@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <h2>Новая продажа</h2>
        {{ Form::model($sale, ['route' => ['admin.sale.store', $sale], 'method' => 'post']) }}
            @include('backend.sale._form')
        {{ Form::close() }}
    </div>
@endsection