<div class="card">
    @if ($product->images->count() > 0)
        <img src="{{ asset('storage/'.$product->images->first()->link) }}" class="card-img-top" alt="{{ $product->title }}">
    @else
        <img src="{{ asset('img/product-no-image.jpeg') }}" class="card-img-top" alt="{{ $product->title }}">
    @endif
    <div class="card-body pb-2">
        <h5 class="card-title">
            <a href="{{ route('products.show', $product) }}" class="stretched-link text-decoration-none text-reset">{!! Str::limit($product->title, 28, '') !!}</a>
            <p class="lead d-inline">
                <span class="badge badge-success">{{ $product->price }} $</span>
            </p>
        </h5>
        <h6 class="card-subtitle mb-2 text-muted">{{$product->hashrate}}{{App\Product::$hashrate_names[$product->hashrate_name]}} | {{$product->power}}W | MOQ {{$product->moq}}pcs</h6>
        <p class="card-text">{!! Str::limit($product->description, 88, '...') !!}</p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item py-2">
            <div class="row">
                <div class="col-auto mr-auto">
                    <img src="{{ asset('img/flags/'.$product->country->alpha2_code.'.gif') }}" class="img-fluid pb-1" alt="{{$product->country->alpha2_code}}">
                    <small>{!! Str::limit($product->country->name, 22, '') !!}</small>
                    {{-- <p class="h5 d-inline">
                        <span class="badge badge-secondary font-weight-light">{{$product->quantity}}pcs</span>
                    </p> --}}
                </div>
                <div class="col-auto">
                    @foreach ($product->user->contacts as $contact)
                        @if ($contact->type == 'tg')
                            <i class="fab fa-telegram fa-lg"></i>
                        @elseif ($contact->type == 'phone')
                            <i class="fas fa-phone-alt fa-lg"></i>
                        @elseif ($contact->type == 'whatsapp')
                            <i class="fab fa-whatsapp fa-lg"></i>
                        @endif
                    @endforeach
                </div>
            </div>
        </li>
    </ul>
    {{-- <div class="card-body">
        <a href="#" class="card-link">Favorite</a>
        <a href="{{ route('products.show', $product) }}" class="card-link">More</a>
        <a href="{{ route('products.edit', $product) }}" class="card-link">Edit</a>
    </div> --}}
    <div class="card-footer text-muted py-2">
        <div class="row">
            <div class="col-auto mr-auto">
                Created: {{ date('j M Y', strtotime($product->created_at)) }}
            </div>
            <div class="col-auto">
                <small><i class="far fa-eye"></i> 236</small>
            </div>
        </div>
    </div>
</div>