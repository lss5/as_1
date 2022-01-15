@extends('layouts.app')

@section('content')
    <div class="container">
        <h3> Listing #{{ $product->id }} </h3>
        <div class="form-inline">
            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary mx-1" role="button">
                <b><i class="fas fa-pen"></i>EDIT</b>
            </a>
            <a class="btn btn-secondary mx-1" href="{{ route('admin.products.index') }}">
                <i class="fas fa-list"></i>LIST
            </a>
        </div>
    </div>
    
    <div class="container mt-3">
        <table class="table table-sm table-striped">
            <tbody>
                <tr>
                    <th scope="col" class="text-right" width="30%">ID</th>
                    <td class="text-left">{{ $product->id }}</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Title</th>
                    <td class="text-left">{{ $product->title }}</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Description</th>
                    <td class="text-left">{{ $product->description }}</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Date create</th>
                    <td class="text-left">{{ date('d M Y H:i:s', strtotime($product->created_at)) }}</td>
                </tr>
                <tr>
                    <th scope="col" class="text-right" width="30%">Date update</th>
                    <td class="text-left">{{ date('d M Y H:i:s', strtotime($product->updated_at)) }}</td>
                </tr>
            </tbody>
        </table>
        <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-danger mx-1" onclick='return confirm("Удалить ?");'>
                <i class="fas fa-trash"></i>DELETE
            </button>
        </form>
    </div>
@endsection