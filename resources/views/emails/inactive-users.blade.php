@component('mail::message')
Hello ADMIN 
<br>
There are some student and teacher are inactive 
<br>
<ul>
    @foreach ($users as $user)
    <li>Name:- {{ $user->name }} </li>
    @endforeach
    
</ul>

@component('mail::button', ['url' => '/'])
Visit
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
