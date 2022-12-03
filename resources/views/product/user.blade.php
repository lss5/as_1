@extends('layouts.app')

@section('content')
<div class="container my-3 py-3">
    <h1 class="h3">{{ $user->name }} seller</h1>
    @if($user->hasVerifiedUser())
        <h6 class="text-success"><i class="fas fa-user-check text-success"></i> Verified seller</h6>
    @endif
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <table class="table w-100">
                <tbody>
                    <tr>
                        <th scope="row" colspan="2" class="text-center"><b>{{ $user->first_name }} {{ $user->last_name }}</b></td>
                    </tr>
                    <tr>
                        <th scope="row">Country</th>
                        <td>{{ $user->country->name }} <img src="{{ asset('img/flags/'.$user->country->alpha2_code.'.gif') }}" class="img-fluid" alt="{{$user->country->alpha2_code}}"></td>
                    </tr>
                    <tr>
                        <th scope="row">E-mail</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                </tbody>
              </table>
        </div>
        <div class="col-sm-12 col-md-6">
            <table class="table w-100">
                <tbody>
                    <tr>
                        <th scope="row" colspan="2" class="text-center">
                            Contacts
                            @if (Auth::check() && $user->id != Auth::id())
                                <form action="{{ route('messages.create', $user) }}" method="GET" class="d-inline">
                                    <button type="submit" class="btn btn-sm btn-success mx-1">
                                        {{__('message.action.create')}} <i class="fas fa-envelope"></i>
                                    </button>
                                </form>
                            @endif
                        </th>
                    </tr>
                    {{-- @if($user->contacts()->count() < 1)
                        <tr>
                            <td colspan="2">Please add contact number</td>
                        </tr>
                    @else
                        @foreach ($user->contacts as $contact)
                            <tr>
                                <th scope="row">{{ App\Contact::$types[$contact->type] }}</th>
                                <td>{{ $contact->value }}</td>
                            </tr>
                        @endforeach
                    @endif --}}
                </tbody>
              </table>
        </div>
    </div>
    <div class="row my-2">
        @if($products->count() < 1)
            <div class="col-12">
                <h5>No listings</h5>
            </div>
        @else
            <div class="col-12">
                <h2 class="h4">listings</h1>
            </div>
            @forelse ($products as $product)
                <div class="col-sm-12 col-md-6 col-lg-4 my-1">
                    @include('partials.product_card')
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
