@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Notification</h1>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                @include('partials.alerts')

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header p-2">
                                <h3 class="card-title">Setting</h3>
                            </div>
                            <div class="card-body">
                                <form class="form-horizontal" action="{{ route('profile.notifications.update') }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-group ">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="form-check-label">New personal message</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" checked>
                                            <label class="form-check-label">Change status listing</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="form-check-label">News asicseller plathform</label>
                                        </div>
                                      </div>
                                    <div class="form-group row">
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
