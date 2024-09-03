<div class="d-flex justify-content-between my-2">
    <div class="m-0 p-0">
        <a href="{{ route('profile.message.index') }}" class="btn btn-sm {{ request()->routeIs('messages*') ? 'btn-secondary' : 'btn-outline-secondary' }}">
            {{ __('message.action.index') }} <i class="far fa-comments"></i>
        </a>
        <a href="{{ route('profile.support.index') }}" class="btn btn-sm {{ request()->routeIs('support*') ? 'btn-secondary' : 'btn-outline-secondary' }}">
            {{ __('support.action.index') }} <i class="fas fa-headset"></i>
        </a>
    </div>
    <a href="{{ route('profile.support.create') }}" class="btn btn-sm btn-success">
        <i class="fas fa-plus"></i> {{ __('support.action.create') }}
    </a>
</div>