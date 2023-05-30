<x-mail::message>
# Welcome

Congratulation!, your account has successfully created. Now you can choose and start with our Bootcamp

<x-mail::button :url="route('login')">
Login Here
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
