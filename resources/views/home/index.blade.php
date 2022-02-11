@extends('home.layout')

@section('content_p')
<div class="row">
    <div class="col-12">
        <h1 class="h3">Your account</h1>
    </div>
</div>
<div class="row">
    <div class="col-12">
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table w-auto">
            <tbody>
                <tr>
                    <th scope="row">Username</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th scope="row">Country</th>
                    <td>{{ $user->country->name }} <img src="{{ asset('img/flags/'.$user->country->alpha2_code.'.gif') }}" class="img-fluid" alt="{{$user->country->alpha2_code}}"></td>
                </tr>
                <tr>
                    <th scope="row">First name</th>
                    <td>{{ $user->first_name }}</td>
                </tr>
                <tr>
                    <th scope="row">Last name</th>
                    <td>{{ $user->last_name }}</td>
                </tr>
                @if($user->contacts()->count() < 1)
                    <tr>
                        <th scope="row">Contact</th>
                        <td>Please add contact number</td>
                    </tr>
                @else
                    @foreach ($user->contacts as $contact)
                        <tr>
                            <th scope="row">{{ App\Contact::$types[$contact->type] }}</th>
                            <td>{{ $contact->value }}</td>
                        </tr>
                    @endforeach
                @endif
                <tr>
                    <th scope="row">2-Step Verification</th>
                    <td>
                        @if($user->ga_verify)
                            <span class="text-success"><b>On</b></span>
                        @else
                            Off
                            <a href="{{ route('home.f2a', $user) }}" type="button" class="btn btn-outline-success btn-sm mx-2">Enable</a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row">Subscription</th>
                    <td>Start</td>
                </tr>
                <tr>
                    <th scope="row">Listings/Limits</th>
                    <td>{{ $user->products()->count() }}/<span class="text-success">{{ config('product.limit_create_listing') }}</span></td>
                </tr>
            </tbody>
          </table>
    </div>
</div>
@endsection
