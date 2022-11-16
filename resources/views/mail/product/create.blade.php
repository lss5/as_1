@component('mail::message')
# {{ $product_title }}

# @lang('mail.product.created.title')

@lang('mail.product.created.body')

@component('mail::button', ['url' => $url ?? ''])
    View Listing
@endcomponent

Thanks, {{ $user }}<br>
{{ config('app.name') }}
@endcomponent
