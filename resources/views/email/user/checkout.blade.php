<x-mail::message>
# Register Bootcamp: {{ $checkout->camp->title }}

Hi,

Thank you for register {{ $checkout->camp->title }}, please see payment details by click button below

<x-mail::button :url="route('user.checkout.invoice', ['checkout' => $checkout])">
Get Invoice
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
