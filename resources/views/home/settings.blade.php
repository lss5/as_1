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
<hr class="py-2">
<h3 class="font-weight-light">{{ __('Contacts') }}</h3>
<div class="row">
    @forelse($user->contacts as $contact)
    <div class="col-sm-12 col-md-6 mb-3">
        <div class="input-group">
            <div class="input-group-prepend">
                <label for="contact-buttons-{{ $contact->id }}" class="input-group-text">{{ App\Contact::$types[$contact->type] }}</label>
            </div>
            <input readonly type="text" class="input-group-text rounded-0" placeholder="{{ $contact->value }}" aria-label="Contact value" aria-describedby="contact-buttons-{{ $contact->id }}">
            <div class="input-group-append" id="contact-buttons-{{ $contact->id }}">
                <form action="{{ route('home.contacts.setmain', $contact) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <button type="submit" class="btn @if($contact->ismain) btn-primary @else btn-outline-primary @endif">Main</button>
                </form>
                <form action="{{ route('home.contacts.destroy', $contact) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" onclick='return confirm("Delete contact?");' class="btn btn-outline-danger mx-1" onclick='return confirm("Удалить ?");'>
                        <i class="fas fa-trash"></i>Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="row">
    <div class="col-sm-12 col-lg-6 form-group">
        <form action="{{ route('home.contacts.store', $user) }}" method="POST">
            @csrf
            <div class="input-group mb-3">
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
            </div>
            <div class="col-sm-12 col-md-12 my-1">
                <button type="submit" onclick='return confirm("Add contact?");' class="btn btn-outline-success">Add contact</button>
            </div>
        </form>
    </div>
</div>
@endsection
