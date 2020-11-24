@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ Auth::user()->name }} Posts
                    <a href="{{ route('posts.create') }}" class="btn btn-success ml-3">Add new</a>
                </div>

                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
