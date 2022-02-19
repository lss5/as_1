<div class="list-group list-group-flush">
    <a href="{{ route('home.index') }}" class="list-group-item d-flex justify-content-between align-items-center list-group-item-action" aria-current="true">
        {{ __('Profile') }}
    </a>
    <a href="{{ route('home.listings') }}" class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">{{ __('Listings') }}</a>
    <a href="{{ route('home.settings') }}" class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">{{ __('Settings') }}</a>
    <a href="{{ route('home.messages.index') }}" class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
        {{ __('Messages') }}
        <?php $count = Auth::user()->newThreadsCount(); ?>
        @if($count > 0)
            <span class="badge badge-success badge-pill">{{ $count }}</span>
        @endif
    </a>
    <a class="list-group-item list-group-item-action disabled">Subscription</a>
</div>
