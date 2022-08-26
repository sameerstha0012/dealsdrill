@component('mail::message')

Thanks for registering an Amerciar Account. Account detaials are below.

Email : $user->email
Password : $password

Thanks,<br>
{{ config('app.name') }}
@endcomponent
