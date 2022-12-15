@extends('admin.layout')

@section('content_p')
<div class="row my-2">
    <div class="col-12">
        <h3>Registered users</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Products</th>
                    <th scope="col">Roles</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>
                        @if($user->hasVerifiedUser()) <i class="fas fa-user-check text-success" data-toggle="tooltip" data-placement="top" title="user verified:{{ $user->user_verified_at }}"></i>@endif
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->email }}
                        @if($user->hasVerifiedEmail()) <i class="fas fa-envelope text-primary" data-toggle="tooltip" data-placement="top" title="email verified:{{ $user->email_verified_at }}"></i>@endif
                        @if($user->hasVerifiedGA()) <i class="fab fa-google-plus text-muted" data-toggle="tooltip" data-placement="top" title="2FA verified:{{ $user->ga_verified_at }}"></i>@endif
                    </td>
                    <td>{{ $user->products()->count() }}</td>
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
            <script>
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            </script>
        </table>
    </div>
</div>
@endsection
