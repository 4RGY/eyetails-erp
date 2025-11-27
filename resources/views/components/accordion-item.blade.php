{{--
File: resources/views/components/accordion-item.blade.php
Ini adalah komponen untuk satu baris dropdown.
--}}

@props(['title'])

{{--
Kita pakai Alpine.js (x-data) untuk menyimpan state 'open' (terbuka/tertutup).
Ini adalah bagian dari TALL stack dan sudah ada di project Anda (app.js).
--}}
<div x-data="{ open: false }" class="border-b border-gray-200">
    <h2>
        {{-- Tombol untuk Trigger Buka/Tutup --}}
        <button type="button" x-on:click="open = !open"
            class="flex items-center justify-between w-full py-5 px-6 text-left text-lg font-medium text-gray-800 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50"
            :aria-expanded="open">

            {{-- Judul (diambil dari prop 'title') --}}
            <span>{{ $title }}</span>

            {{-- Icon Panah (berputar otomatis saat 'open' true) --}}
            <svg class.="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-180': open, 'rotate-0': !open }"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </button>
    </h2>

    {{-- Konten/Isi Dropdown --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2" class="pb-5 px-6" style="display: none;"> {{-- style="display:
        none;" untuk fallback jika JS tidak aktif --}}

        {{--
        Class 'prose' dari plugin Tailwind Typography.
        Ini PENTING: 'prose' akan otomatis memformat paragraf (<p>), list (
        <ul>), dll.
            menjadi rapi tanpa perlu styling manual. Inilah yang membuatnya tidak "AI-generated".
            --}}
            <div class="prose max-w-none text-gray-700">
                {{ $slot }} {{-- $slot adalah tempat konten/deskripsi dimasukkan --}}
            </div>
    </div>
</div>