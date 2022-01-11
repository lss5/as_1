@extends('backend.layouts.app')

@section('content')
    <div class="container">
        <h2>Изменение продажи #{{ $sale->id }}</h2>
        {{ Form::model($sale, ['route' => ['admin.sale.update', $sale], 'method' => 'put']) }}
            @include('backend.sale._form')
        {{ Form::close() }}
    </div>
@endsection