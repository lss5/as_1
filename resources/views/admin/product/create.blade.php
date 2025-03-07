@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Creating new product model</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('admin.products.store') }}" class="w-100" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputImage">Default photo</label>
                                    <input type="file" id="inputImage" name="image" class="form-control-file  @error('image') is-invalid @enderror">
                                    @error('image')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="selectManufacturer">Manufacturer</label>
                                    <select class="custom-select rounded-0 @error('manufacturer') is-invalid @enderror" name="manufacturer" id="selectManufacturer">
                                        <option @empty(old('manufacturer')) selected @endempty>Please select</option>
                                        @foreach ($manufacturers as $manufacturer)
                                            <option value="{{ $manufacturer->id }}" @if(old('manufacturer') == $manufacturer->id) selected @endif>{{ $manufacturer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputModel">Model</label>
                                    <input type="text" id="inputModel" name="model" class="form-control  @error('model') is-invalid @enderror" value="{{ old('model') }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputHashrate">Hashrate, h/s</label>
                                    <input type="number" step="0.1" id="inputHashrate" name="hashrate" class="form-control  @error('hashrate') is-invalid @enderror" value="{{ old('hashrate') }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputPower">Power, watts</label>
                                    <input type="number" step="0.1" id="inputPower" name="power" class="form-control  @error('power') is-invalid @enderror" value="{{ old('power') }}">
                                </div>
                                <div class="form-group">
                                    <label>Algorithms</label>
                                    <select multiple class="form-control @error('algorithms') is-invalid @enderror" name="algorithms[]">
                                        @foreach ($algorithms as $algorithm)
                                            <option value="{{ $algorithm->id }}">{{ $algorithm->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('algorithms')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Coins</label>
                                    <select multiple class="form-control @error('coins') is-invalid @enderror" name="coins[]">
                                        @foreach ($coins as $coin)
                                            <option value="{{ $coin->id }}">{{ $coin->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('coins')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputWeight">Weight, gramm</label>
                                    <input type="number" step="0.1" id="inputWeight" name="weight" class="form-control  @error('weight') is-invalid @enderror" value="{{ old('weight') }}">
                                </div>
                                <div class="form-group">
                                    <label for="selectCooling">Cooling</label>
                                    <select class="custom-select rounded-0 @error('cooling') is-invalid @enderror" name="cooling" id="selectCooling">
                                        <option @empty(old('cooling')) selected @endempty>Please select</option>
                                        @foreach ($coolings as $key => $name)
                                            <option value="{{ $key }}" @if(old('cooling') == $key) selected @endif>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                        <input type="submit" value="Create" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
