@component('mail::message')

You have a new message in the thread with the subject: {{ $thread_subject }}

> *{{ $message }}*

@component('mail::button', ['url' => $url ?? ''])
View thread
@endcomponent

Thanks, {{ $user }}<br>
{{ config('app.name') }}
@endcomponent
