@component('mail::message')
# {{ $product_title }}

# @lang('mail.product.activated.title')

@lang('mail.product.activated.body')

@component('mail::button', ['url' => $url ?? ''])
    View Listing
@endcomponent
Thanks, {{ $user }}<br>
{{ config('app.name') }}
@endcomponent
