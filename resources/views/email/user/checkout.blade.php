<x-mail::message>
# Register Bootcamp: {{ $checkout->camp->title }}

Hi,

Thank you for register {{ $checkout->camp->title }}, you can see your class at your Dashboard page

<x-mail::button :url="route('dashboard')">
My Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
