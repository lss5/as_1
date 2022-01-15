<div class="card">
    {{-- <img src="..." class="card-img-top" alt="..."> --}}
    <div class="card-body">
        <h5 class="card-title"><a href="{{ route('products.show', $product) }}">{{ $product->title }}</a></h5>
        <p class="card-text">{!! Str::limit($product->description, 88, '...') !!}</p>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">560$</li>
        <li class="list-group-item">@telegram</li>
    </ul>
    <div class="card-body">
        <a href="#" class="card-link">Favorite</a>
        <a href="{{ route('products.show', $product) }}" class="card-link">More</a>
    </div>
</div>