{{-- resources/views/loyalty-terms.blade.php --}}

@extends('layouts.app')

@section('title', 'Syarat Loyalitas | eyetails.co')

{{--
======================================================================
TAMBAHAN CSS KUSTOM UNTUK ACCORDION
======================================================================
--}}
@push('styles')
<style>
    /* Styling untuk Header Halaman */
    .page-header {
        padding: 2.5rem 1rem;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
    }

    .page-header h1 {
        font-size: 2.25rem;
        /* 36px */
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .page-header p {
        font-size: 1.125rem;
        /* 18px */
        color: #555;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Styling Kontainer Accordion */
    .faq-content {
        padding-top: 3rem;
        padding-bottom: 3rem;
        max-width: 800px;
        /* Sedikit lebih lebar untuk konten */
    }

    /* Styling Accordion Wrapper */
    .accordion {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        /* Penting untuk border-radius */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    /* Styling per Item */
    .accordion-item {
        border-bottom: 1px solid #ddd;
    }

    .accordion-item:last-child {
        border-bottom: none;
        /* Hapus border di item terakhir */
    }

    /* Styling Tombol Header */
    .accordion-header {
        /* Reset default button styles */
        background: #ffffff;
        border: none;
        padding: 1.5rem;
        width: 100%;
        text-align: left;
        cursor: pointer;

        /* Flexbox untuk layout */
        display: flex;
        justify-content: space-between;
        align-items: center;

        /* Font styling */
        font-size: 1.125rem;
        /* 18px */
        font-weight: 600;
        color: #333;

        /* Transisi */
        transition: background-color 0.3s ease;
    }

    .accordion-header:hover {
        background-color: #f7f7f7;
    }

    /* Styling Icon Chevron */
    .accordion-header i {
        font-size: 0.9rem;
        color: #555;
        transition: transform 0.3s ease;
    }

    /* Styling Header saat AKTIF */
    .accordion-header.active {
        background-color: #f7f7f7;
        color: #0056b3;
        /* Warna aksen (biru) saat aktif */
    }

    .accordion-header.active i {
        transform: rotate(180deg);
        color: #0056b3;
    }

    /* Styling Konten Body */
    .accordion-body {
        max-height: 0;
        /* Default tertutup */
        overflow: hidden;
        transition: max-height 0.35s ease-out;
        background-color: #ffffff;
    }

    /* Wrapper untuk padding di dalam body */
    .accordion-body-content {
        padding: 0 1.5rem 1.5rem 1.5rem;
        color: #444;
        line-height: 1.7;
    }

    .accordion-body-content p {
        margin-bottom: 1rem;
    }

    .accordion-body-content p:last-child {
        margin-bottom: 0;
    }

    .accordion-body-content ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-top: -0.5rem;
        margin-bottom: 1rem;
    }

    .accordion-body-content li {
        margin-bottom: 0.5rem;
    }

    /* ======================================================================
     RESPONSIVE
    ====================================================================== 
    */
    @media (max-width: 640px) {
        .page-header h1 {
            font-size: 1.75rem;
            /* 28px */
        }

        .page-header p {
            font-size: 1rem;
            /* 16px */
        }

        .faq-content {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .accordion-header {
            padding: 1.25rem;
            font-size: 1rem;
            /* 16px */
        }

        .accordion-body-content {
            padding: 0 1.25rem 1.25rem 1.25rem;
            font-size: 0.95rem;
        }
    }
</style>
@endpush


{{--
======================================================================
KONTEN HTML HALAMAN
======================================================================
--}}
@section('content')

{{-- Header Halaman --}}
<section class="page-header container text-center">
    <h1>PROGRAM LOYALITAS PELANGGAN</h1>
    <p>Pahami cara kerja poin, tier, dan keuntungan eksklusif Anda di sini.</p>
</section>

{{-- Konten Accordion --}}
<section class="faq-content container">
    <div class="accordion"> {{-- Class accordion utama --}}

        {{-- Item 1 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>1. Apa itu Poin Loyalitas?</span> {{-- Tambahan span agar lebih rapi --}}
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content"> {{-- Wrapper untuk padding --}}
                    <p>Poin Loyalitas adalah poin reward yang Anda dapatkan setiap kali bertransaksi. Poin ini dapat
                        dikumpulkan dan ditukar dengan diskon langsung, produk gratis, atau voucher belanja.</p>
                </div>
            </div>
        </div>

        {{-- Item 2 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>2. Bagaimana Cara Mendapatkan Poin?</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content">
                    <p>Anda akan mendapatkan poin untuk aktivitas berikut:</p>
                    <ul>
                        <li><strong>Belanja:</strong> Setiap kelipatan Rp 10.000,- dari total harga produk (di luar
                            ongkir) akan mendapatkan 1 Poin.</li>
                        <li><strong>Ulasan Produk:</strong> Berikan ulasan berkualitas (dengan foto/video) untuk produk
                            yang Anda beli.</li>
                        <li><strong>Promo Spesial:</strong> Dapatkan poin bonus selama periode promosi tertentu.</li>
                    </ul>
                    <p>Poin akan masuk ke akun Anda secara otomatis setelah pesanan berstatus 'Selesai' (Completed).</p>
                </div>
            </div>
        </div>

        {{-- Item 3 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>3. Penukaran Poin (Redeem)</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content">
                    <p>Poin bisa Anda tukarkan di halaman checkout sebagai potongan harga. Anda dapat melihat jumlah
                        poin Anda di halaman 'Akun Saya'.</p>
                    <p>Nilai tukar saat ini: <strong>1 Poin = Rp 100,-</strong> (seratus Rupiah).</p>
                    <p>Minimum penukaran adalah 1.000 Poin (setara diskon Rp 10.000,-).</p>
                </div>
            </div>
        </div>

        {{-- Item 4 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>4. Masa Berlaku Poin</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content">
                    <p>Setiap Poin Loyalitas yang Anda peroleh berlaku selama <strong>12 (dua belas) bulan</strong>
                        sejak tanggal poin didapatkan.</p>
                    <p>Contoh: Poin yang Anda dapatkan pada 25 Oktober 2025 akan hangus pada 24 Oktober 2026. Kami akan
                        mengirimkan email pengingat 30 hari sebelum poin Anda hangus.</p>
                </div>
            </div>
        </div>

        {{-- Item 5 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>5. Ketentuan Lainnya</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content">
                    <p>Program ini diatur oleh syarat dan ketentuan umum perusahaan. Kami berhak mengubah mekanisme,
                        nilai tukar, atau masa berlaku poin sewaktu-waktu. Segala keputusan terkait program ini bersifat
                        final.</p>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

{{--
======================================================================
SCRIPT JAVASCRIPT ACCORDION
======================================================================
--}}
@push('scripts')
<script>
    function toggleAccordion(header) {
        // Toggle class 'active' pada header yang diklik
        header.classList.toggle('active');
        
        var body = header.nextElementSibling;
        
        // Logika untuk membuat transisi smooth (menggunakan maxHeight)
        if (body.style.maxHeight) {
            // Tutup
            body.style.maxHeight = null;
        } else {
            // Buka, set tinggi ke tinggi konten agar smooth transition
            // Kita ambil scrollHeight dari .accordion-body-content di dalamnya
            var content = body.querySelector('.accordion-body-content');
            body.style.maxHeight = content.scrollHeight + "px";
        }
        
        // Opsional: Tutup item lain (jika ingin satu per satu)
        document.querySelectorAll('.accordion-header').forEach(h => {
            if (h !== header && h.classList.contains('active')) {
                 h.classList.remove('active');
                 h.nextElementSibling.style.maxHeight = null;
            }
        });
    }

    // [Opsional] PENTING: Untuk responsiveness jika user resize window
    // Jika user resize window saat accordion terbuka, maxHeight-nya bisa salah.
    // Kita buat fungsi untuk auto-adjust.
    window.addEventListener('resize', () => {
        document.querySelectorAll('.accordion-header.active').forEach(header => {
            var body = header.nextElementSibling;
            var content = body.querySelector('.accordion-body-content');
            body.style.maxHeight = content.scrollHeight + "px";
        });
    });
</script>
@endpush