@component('mail::message')
# @lang('mail.product.moderation.title'){{ $status }}

@lang('mail.product.moderation.body')

@component('mail::button', ['url' => $url ?? ''])
    View Listing
@endcomponent
Thanks, {{ $user }}<br>
{{ config('app.name') }}
@endcomponent
