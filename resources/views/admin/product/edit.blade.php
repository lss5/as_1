@extends('layouts.admin')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editing {{ $product->model }}</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <form method="POST" action="{{ route('admin.products.update', $product) }}" class="w-100" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputImage">Default photo</label>
                                    <input type="file" id="inputImage" name="image" class="form-control-file">
                                    @error('image')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="selectManufacturer">Manufacturer</label>
                                    <select class="custom-select rounded-0 @error('manufacturer') is-invalid @enderror" name="manufacturer" id="selectManufacturer">
                                        <option @empty(old('manufacturer')) selected @endempty>Please select</option>
                                        @foreach ($manufacturers as $manufacturer)
                                            <option value="{{ $manufacturer->id }}" @if(old('manufacturer') == $manufacturer->id || $product->manufacturer_id == $manufacturer->id) selected @endif>{{ $manufacturer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputModel">Model</label>
                                    <input type="text" id="inputModel" name="model" class="form-control  @error('model') is-invalid @enderror" value="{{ old('model') ?? $product->model }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputHashrate">Hashrate</label>
                                    <input type="number" step="0.1" id="inputHashrate" name="hashrate" class="form-control  @error('hashrate') is-invalid @enderror" value="{{ old('hashrate') ?? $product->hashrate }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputPower">Power</label>
                                    <input type="number" step="0.1" id="inputPower" name="power" class="form-control  @error('power') is-invalid @enderror" value="{{ old('power') ?? $product->power }}">
                                </div>
                                <div class="form-group">
                                    <label>Algorithms</label>
                                    <select multiple class="form-control @error('algorithms') is-invalid @enderror" name="algorithms[]">
                                        @foreach ($algorithms as $algorithm)
                                            <option value="{{ $algorithm->id }}" @if (in_array($algorithm->id, $product->algorithms->pluck('id')->toArray())) selected @endif>{{ $algorithm->name }}</option>
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
                                            <option value="{{ $coin->id }}" @if (in_array($coin->id, $product->coins->pluck('id')->toArray())) selected @endif>{{ $coin->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('coins')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Profits</h3>
                            </div>
                            <div class="card-body">
                                @if ($product->profits->count() > 0)
                                    <ul>
                                        @foreach ($product->profits as $profit)
                                        <li>
                                            {{ $profit->coin_tag }}:{{ $profit->cost/100 }} updated {{ $profit->updated_time->isoFormat('DD MMM HH:MM') }}
                                        </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <input type="submit" value="Save" class="btn btn-success">
                        <a href="{{ route('admin.profits.update', $product) }}" class="btn btn-secondary ml-2">Update profit</a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary float-right">Cancel</a>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
