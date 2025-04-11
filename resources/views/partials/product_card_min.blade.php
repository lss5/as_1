<div class="card">
    @if ($product->images->count() > 0)
        <img src="{{ asset('storage/'.$product->images->first()->link) }}" class="card-img-top" alt="{{ $product->title }}">
    @else
        <img src="{{ asset('images/common/no-product-image.png') }}" class="card-img-top" alt="{{ $product->title }}">
    @endif
    <div class="card-body pb-2">
        <h5 class="card-title">
            <a href="{{ route('listings.show', $product) }}" class="stretched-link text-decoration-none text-reset">{!! Str::limit($product->product->model, 22, '') !!}</a>

        </h5>
        <h6 class="card-subtitle mb-2 text-muted"> {{$product->moq}}pcs</h6>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item py-2">
            <div class="row">
                <div class="col-auto mr-auto">
                    <img src="{{ asset('img/flags/'.$product->country->alpha2_code.'.gif') }}" class="img-fluid pb-1" alt="{{$product->country->alpha2_code}}">
                    <small>{!! Str::limit($product->country->name, 20, '') !!}</small>
                </div>
                <div class="col-auto">
                    <p class="h5 d-inline">
                        @if($product->user->hasVerifiedUser())
                            <span class="badge badge-success">{{ $product->price }} $</span>
                        @else
                            <span class="badge badge-secondary">{{ $product->price }} $</span>
                        @endif
                    </p>
                </div>
            </div>
        </li>
    </ul>
</div>
