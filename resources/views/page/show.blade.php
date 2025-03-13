@extends('layouts.app')

@section('content')
<div class="container py-3 my-3">
    <div class="row">
        <h1 class="h3">{{ $page->name }}</h1>
        <div class="col-12">
            {!! $page->content !!}
        </div>
    </div>
</div>
@endsection
