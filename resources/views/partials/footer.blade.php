<div class="container pt-4 pb-2">
    <div class="row">
        @foreach ($sections as $section)
            <div class="col-6 col-lg-3">
                <h5>{{ $section->name }}</h5>
                <ul class="list-unstyled text-small">
                    @foreach ($section->pages as $item)
                        <li><a class="text-muted" href="{{ route('pages.show', $item) }}">{{ $item->list_name }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endforeach
        <div class="col-12 d-flex flex-column align-items-center">
            <img class="mb-2" src="{{ asset('images/common/logo-with-name.png') }}" alt="" width="118" height="66">
            <small class="d-block mb-3 text-muted">© 2020-2023</small>
        </div>
    </div>
</div>
