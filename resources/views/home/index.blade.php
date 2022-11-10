@extends('home.layout')

@section('content_p')
<div class="row d-flex justify-content-start">
        <div class="col-12 col-lg-8 mx-auto">
        <h1 class="h4 my-2">{{ __('home.pages.index') }}</h1>
        <table class="table w-100">
            <tbody>
                <tr>
                    <th scope="row">Username</th>
                    <td>
                        {{ $user->name }}
                        @if($user->hasVerifiedUser())
                            <span class="text-success"><b>(verified)</b></span>
                        @else
                            <a href="#" type="button" class="btn btn-success btn-sm mx-2">Verify <i class="fas fa-user-check"></i></a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row">First name</th>
                    <td>{{ $user->first_name }}</td>
                </tr>
                <tr>
                    <th scope="row">Last name</th>
                    <td>{{ $user->last_name }}</td>
                </tr>
                <tr>
                    <th scope="row">E-mail</th>
                    <td>
                        {{ $user->email }}
                        @if($user->hasVerifiedEmail())
                            <span class="text-success"><b>(verified)</b></span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th scope="row">Country</th>
                    <td>{{ $user->country->name }} <img src="{{ asset('img/flags/'.$user->country->alpha2_code.'.gif') }}" class="img-fluid" alt="{{$user->country->alpha2_code}}"></td>
                </tr>
            </tbody>
        </table>

        <h2 class="h4">Contacts</h2>
        <table class="table w-100">
            <tbody>
                @if($user->contacts()->count() > 0)
                    @foreach ($user->contacts as $contact)
                        <tr>
                            <td colspan="2" class="d-flex justify-content-start align-items-center flex-wrap">
                                {{ App\Contact::$types[$contact->type] }}
                                <form action="{{ route('home.contacts.setmain', $contact) }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <button type="submit" class="btn btn-sm @if($contact->ismain) btn-primary @else btn-outline-primary @endif ml-1" onclick="return confirm('Set main this contact?');">
                                        Main
                                    </button>
                                </form>
                                <form action="{{ route('home.contacts.destroy', $contact) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger ml-1" onclick="return confirm('Delete contact?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <b class="ml-auto">{{ $contact->value }}</b>
                            </td>
                            <th scope="row align-left">
                            </th>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2">
                            Please enter correct contact information
                        </td>
                    </tr>
                @endif
                <tr>
                    <td colspan="2">
                        <form action="{{ route('home.contacts.store', $user) }}" method="POST" class="row">
                            @csrf
                            <div class="input-group col px-1">
                                <div class="input-group-prepend">
                                        <select class="custom-select @error('type') is-invalid @enderror" name="type" id="type">
                                            @foreach (App\Contact::$types as $uniq => $name)
                                                <option @if(old('type') == $uniq) selected @endif value="{{ $uniq }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" name="value" id="value" value="{{ old('value') ?? '' }}" class="form-control @error('value') is-invalid @enderror" aria-label="value">
                                    @error('value')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-auto px-1">
                                    <button type="submit" onclick='return confirm("Add contact?");' class="btn btn-outline-success">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
        <h2 class="h4">Security</h2>
        <table class="table w-100">
            <tbody>
                <tr>
                    <th scope="row">2FA Authentication App (TOTP)
                    </th>
                    
                    <td>
                        @if($user->hasVerifiedGA())
                            <span class="text-success"><b>On</b></span>
                        @else
                            Off
                            <a href="{{ route('home.f2a', $user) }}" type="button" class="btn btn-outline-success btn-sm mx-2" title="Switch to Authentication App (TOTP) now">Enable</a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <small>As we are constantly improving privacy, security and integrity, AsicSeller establishes TOTP - Time-based One-Time Password providing the option to use one-time passwords generated by app, like Google Authenticator to protect your account.</small>
                    </td>
                </tr>
            </tbody>
        </table>
        <h2 class="h4">Subscription</h2>
        <table class="table w-100">
            <tbody>
                <tr>
                    <th scope="row">Plan</th>
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
<div class="row">
    <div class="col-12">
        <a href="{{ route('home.edit') }}" type="button" class="btn btn-outline-secondary btn-sm mx-1">{{ __('product.btn.edit') }}</a>
    </div>
</div>
@endsection
