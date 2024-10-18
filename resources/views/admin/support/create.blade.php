@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">New help request</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                @include('partials.alerts')

                <form method="POST" action="{{ route('admin.supports.store') }}" class="w-100">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="selectUser">User</label>
                                        <select class="custom-select rounded-0 @error('user') is-invalid @enderror" name="user" id="selectUser">
                                            <option @empty(old('user')) selected @endempty>Please select</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" @if(old('user') == $user->id) selected @endif>{{ $user->first_name}} {{ $user->last_name}} ({{ $user->name }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Subject</label>
                                        <input type="text" id="inputSubject" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Message</label>
                                        <textarea class="form-control @error('message') is-invalid @enderror" rows="6" name="message" placeholder="Describe the problem ...">{{ old('message') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <input type="submit" value="Send" class="btn btn-success">
                            <a href="{{ route('admin.supports.index') }}" class="btn btn-secondary float-right">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
