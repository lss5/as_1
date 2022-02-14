@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 my-2">
            <h3>Registered users</h3>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col"><small>Name</small></th>
                        <th scope="col"><small>Email</small></th>
                        <th scope="col"><small>Contacts</small></th>
                        <th scope="col"><small>Products</small></th>
                        <th scope="col"><small>Roles</small></th>
                        <th scope="col"><small>Actions</small></th>
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
                        <td>
                            @foreach ($user->contacts as $contact)
                                @if ($contact->type == 'tg')
                                    <i class="fab fa-telegram fa-sm"></i>
                                @elseif ($contact->type == 'phone')
                                    <i class="fas fa-phone-alt fa-sm"></i>
                                @elseif ($contact->type == 'whatsapp')
                                    <i class="fab fa-whatsapp fa-sm"></i>
                                @endif
                                    {{ $contact->value }}
                            @endforeach
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
</div>
@endsection
