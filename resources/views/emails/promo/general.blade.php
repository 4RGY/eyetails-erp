<x-mail::message>
    # {{ $emailSubject }}

    {!! nl2br(e($emailContent)) !!}

    <x-mail::button :url="route('promo.index')">
        Lihat Semua Promo
    </x-mail::button>

    Terima kasih,<br>
    {{ config('app.name') }}
</x-mail::message>