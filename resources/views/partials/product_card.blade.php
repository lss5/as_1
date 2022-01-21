<div class="card">
    @if ($product->images->count() > 0)
        <img src="{{ asset('storage/'.$product->images->first()->link) }}" class="card-img-top" alt="...">
    @else
        <img src="{{ asset('img/product-no-image.jpeg') }}" class="card-img-top" alt="...">
    @endif
    <div class="card-body">
        <h5 class="card-title"><a href="{{ route('products.show', $product) }}">{{ $product->title }}</a></h5>
        <p class="card-text">{!! Str::limit($product->description, 88, '...') !!}</p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">@telegram | {{ $product->price }}$</li>
    </ul>
    <div class="card-body">
        <a href="#" class="card-link">Favorite</a>
        <a href="{{ route('products.show', $product) }}" class="card-link">More</a>
        <a href="{{ route('products.edit', $product) }}" class="card-link">Edit</a>
    </div>
</div>