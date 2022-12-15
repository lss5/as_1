<div class="container pt-4 pb-2">
    <div class="row">
        <div class="col-6 col-md">
            <h5>About</h5>
            <ul class="list-unstyled text-small">
                @foreach (App\Section::where('uniq_name', 'about')->first()->pages as $item)
                    <li><a class="text-muted" href="{{ route('pages.show', $item) }}">{{ $item->list_name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>Information</h5>
            <ul class="list-unstyled text-small">
                @foreach (App\Section::where('uniq_name', 'information')->first()->pages as $item)
                    <li><a class="text-muted" href="{{ route('pages.show', $item) }}">{{ $item->list_name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>Partners</h5>
            <ul class="list-unstyled text-small">
                @foreach (App\Section::where('uniq_name', 'partners')->first()->pages as $item)
                    <li><a class="text-muted" href="{{ route('pages.show', $item) }}">{{ $item->list_name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>Registration</h5>
            <ul class="list-unstyled text-small">
                @foreach (App\Section::where('uniq_name', 'registration')->first()->pages as $item)
                    <li><a class="text-muted" href="{{ route('pages.show', $item) }}">{{ $item->list_name }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="col-12 d-flex flex-column align-items-center">
            <img class="mb-2" src="{{ asset('img/logo_with_name.png') }}" alt="" width="118" height="66">
            <small class="d-block mb-3 text-muted">© 2020-2023</small>
        </div>
    </div>
</div>