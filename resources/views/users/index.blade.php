@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>Manage users</h3>
            <div class="card">
                <div class="card-header">Users</div>

                <div class="card-body">
                  <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Roles</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($users as $user)
                        <tr>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</td>
                          <td>
                            @can('admin')
                              <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm float-left">Edit</a>
                            @endcan
                            @can('admin')
                              <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="float-left ml-1">
                                @csrf
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                              </form>
                            @endcan
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
