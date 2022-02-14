<div class="card">
    @if ($product->images->count() > 0)
        <img src="{{ asset('storage/'.$product->images->first()->link) }}" class="card-img-top" alt="{{ $product->title }}">
    @else
        <img src="{{ asset('img/product-no-image.png') }}" class="card-img-top" alt="{{ $product->title }}">
    @endif
    <div class="card-body pb-2">
        <h5 class="card-title">
            <a href="{{ route('products.show', $product) }}" class="stretched-link text-decoration-none text-reset">{!! Str::limit($product->title, 28, '') !!}</a>
            <p class="lead d-inline">
                @if($product->user->hasVerifiedUser())
                    <span class="badge badge-success">{{ $product->price }} $</span>
                @else
                    <span class="badge badge-secondary">{{ $product->price }} $</span>
                @endif
            </p>
        </h5>
        <h6 class="card-subtitle mb-2 text-muted">{{$product->hashrate}}{{App\Product::$hashrates[$product->hashrate_name]}} | {{$product->power}}W | MOQ {{$product->moq}}pcs</h6>
        <p class="card-text">{!! Str::limit($product->description, 80, '...') !!}</p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item py-2">
            <div class="row">
                <div class="col-auto mr-auto">
                    <img src="{{ asset('img/flags/'.$product->country->alpha2_code.'.gif') }}" class="img-fluid pb-1" alt="{{$product->country->alpha2_code}}">
                    <small>{!! Str::limit($product->country->name, 22, '') !!}</small>
                </div>
                <div class="col-auto">
                    @if($product->user->hasVerifiedUser())
                        <i class="fas fa-user-check text-success"></i>
                    @else
                        <i class="fas fa-user fa-sm text-muted"></i>
                    @endif
                    {{ $product->user->name}}
                </div>
            </div>
        </li>
    </ul>
    <div class="card-footer text-muted py-2">
        <div class="row">
            <div class="col-auto mr-auto">
                Created: {{ date('j M Y', strtotime($product->created_at)) }}
            </div>
            <div class="col-auto">
                <small><i class="far fa-eye"></i> {{ $product->views }}</small>
            </div>
        </div>
    </div>
</div>