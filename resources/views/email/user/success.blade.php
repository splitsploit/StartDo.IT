<x-mail::message>
# Congratulations!

Your payment has successfully confirmed. Now you can access {{ $checkout->camp->title }}.

<x-mail::button :url="route('user.dashboard')">
My Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
