@component('mail::message')
Hello {{$user->name}}

Your status is {{$user->status}} by admin

@component('mail::button', ['url' => 'http://127.0.0.1:8000/'])
Go to Site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
