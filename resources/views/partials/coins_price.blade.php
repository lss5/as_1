<div class="bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            @foreach($prices as $price)
                <div class="col-sm-6 col-md-3 col-lg-2 text-center mb-2">
                    <span class="lead">
                        <img src="{{ asset('img/coins/'.$price->symbol.'.png') }}" class="img-fluid" style="max-height: 30px" alt="{{$price->symbol}}">
                        {{ round($price->lastPrice, 6) }}$
                    </span>
                    @if($price->priceChangePercent > 0)
                        <div class="h6 mb-0 text-success">
                            ({{ round($price->priceChangePercent, 2) }}%)
                        </div>
                    @else
                        <div class="h6 mb-0 text-danger">
                            ({{ round($price->priceChangePercent, 2) }}%)
                        </div>
                    @endif

                </div>
            @endforeach
        </div>
    </div>
</div>
