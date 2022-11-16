@component('mail::message')
# {{ $product_title }}

# {{ $title }}

{{ $body }}

@component('mail::button', ['url' => $url ?? ''])
    View Listing
@endcomponent
Thanks, {{ $user }}<br>
{{ config('app.name') }}
@endcomponent
