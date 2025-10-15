@props(['name', 'promotions'])

<div x-data="{ show: false }" x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close.stop="show = false" x-on:keydown.escape.window="show = false" x-show="show" class="promo-modal-wrapper"
    style="display: none;">
    {{-- Latar Belakang Overlay --}}
    <div x-show="show" x-transition.opacity.duration.300ms class="promo-modal-overlay" @click="show = false"></div>

    {{-- Konten Modal --}}
    <div x-show="show" x-transition:enter="transition ease-out duration-300ms"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200ms" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90" class="promo-modal-box">

        {{-- Ini memanggil konten yang sudah Anda buat --}}
        <x-promo-modal-content :promotions="$promotions" />

    </div>
</div>