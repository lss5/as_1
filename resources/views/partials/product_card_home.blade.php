<div class="card">
    <div class="card-header">
        @if(is_null($product->active_at))
            <button type="button" class="btn btn-sm btn-outline-secondary">
                On moderation
            </button>
        @else
            @if(now() < $product->active_at)
                <button type="button" class="btn btn-sm btn-success">
                    Active to
                    {{ date('d M', strtotime($product->active_at)) }}
                </button>
            @else
                <button type="button" class="btn btn-sm btn-secondary">
                    Expired
                    {{ date('d M', strtotime($product->active_at)) }}
                </button>
                <form action="{{ route('products.reactivate', $product) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-success btn-sm" type="submit">RePublish</button>
                </form>
            @endif
        @endif
        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">View</a>
    </div>
    @if ($product->images->count() > 0)
        <img src="{{ asset('storage/'.$product->images->first()->link) }}" class="card-img-top" alt="{{ $product->title }}">
    @else
        <img src="{{ asset('img/product-no-image.png') }}" class="card-img-top" alt="{{ $product->title }}">
    @endif
    <div class="card-body pb-2">
        <h5 class="card-title">
            <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-reset">{!! Str::limit($product->title, 28, '') !!}</a>
            
        </h5>
        <h6 class="card-subtitle mb-2 text-muted">{{$product->hashrate}}{{App\Product::$hashrates[$product->hashrate_name]}} | {{$product->power}}W | MOQ {{$product->moq}}pcs</h6>
        <p class="card-text">{!! Str::limit($product->description, 80, '...') !!}</p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item py-2">
            <div class="row">
                <div class="col-auto mr-auto">
                    @if($product->user->hasVerifiedUser())
                        <i class="fas fa-user-check text-success"></i>
                    @else
                        <i class="fas fa-user fa-sm text-muted"></i>
                    @endif
                    {{ $product->user->name}}
                </div>
                <div class="col-auto">
                    <p class="h4 d-inline">
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
    <div class="card-footer text-muted py-2">
        <div class="row">
            <div class="col-auto mr-auto">
                <img src="{{ asset('img/flags/'.$product->country->alpha2_code.'.gif') }}" class="img-fluid pb-1" alt="{{$product->country->alpha2_code}}">
                <small>{!! Str::limit($product->country->name, 35, '') !!}</small>
            </div>
            <div class="col-auto">
                <small><i class="far fa-eye"></i> {{ $product->views }}</small>
            </div>
        </div>
    </div>
    <div class="card-footer text-muted py-2">
        <div class="row">
            <div class="col-auto mr-auto">
                <form action="{{ route('products.destroy', $product) }}" method="POST" class="form-inline">
                    <a href="{{ route('products.edit', $product) }}" type="button" class="btn btn-outline-secondary btn-sm">Edit</a>
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger mx-1" onclick='return confirm("Delete item?");'>
                        Delete <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
            <div class="col-auto">
                
            </div>
        </div>
    </div>
</div>