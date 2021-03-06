@extends('home.layout')

@section('content_p')
<form class="w-100" action="{{ route('home.settings.update', $user) }}" method="POST">
    <h1 class="h3">{{ __('Informations') }}</h1>
    <div class="row">
        @method('PATCH')
        @csrf

        <div class="col-sm-12 col-md-6 mb-3">
            <label for="email">Email</label>
            <input id="email" type="email" @cannot('restore', $user) readonly @endcannot class="form-control" name="email" value="{{ old('email', $user->email) }}" required>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-sm-12 col-md-6 mb-3">
            <label for="name">Username</label>
            <input id="name" type="name" @cannot('restore', $user) readonly @endcannot class="form-control" name="name" value="{{ old('name', $user->name) }}" required>

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-sm-12 col-md-6 mb-3">
            <label for="first_name">First name</label>
            <input id="first_name" name="first_name" type="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $user->first_name) }}" required>

            @error('first_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-sm-12 col-md-6 mb-3">
            <label for="last_name">Last name</label>
            <input id="last_name" name="last_name" type="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $user->last_name) }}">

            @error('last_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-sm-12 col-md-6 mb-3">
            <label for="country">{{ __('Country') }}</label>

            <select name="country" id="country" required class="custom-select @error('country') is-invalid @enderror">
                @foreach (App\Country::all() as $country)
                    <option value="{{ $country->id }}" @if(old('country') == $country->id || $user->country_id == $country->id) selected @endif>{{ $country->name }}</option>
                @endforeach
            </select>
            @error('country')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="col-sm-12 col-md-12 my-1">
            <button type="submit" onclick='return confirm("Save change?");' class="btn btn-outline-success">Save</button>
        </div>
    </div>
</form>
@endsection
