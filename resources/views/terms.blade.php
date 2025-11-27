{{-- resources/views/terms.blade.php --}}

@extends('layouts.app')

@section('title', 'Syarat & Ketentuan | eyetails.co')

{{--
======================================================================
TAMBAHAN CSS KUSTOM UNTUK ACCORDION
(CSS yang sama persis dari halaman sebelumnya)
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
    }

    /* Styling Accordion Wrapper */
    .accordion {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    /* Styling per Item */
    .accordion-item {
        border-bottom: 1px solid #ddd;
    }

    .accordion-item:last-child {
        border-bottom: none;
    }

    /* Styling Tombol Header */
    .accordion-header {
        background: #ffffff;
        border: none;
        padding: 1.5rem;
        width: 100%;
        text-align: left;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1.125rem;
        /* 18px */
        font-weight: 600;
        color: #333;
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
    }

    .accordion-header.active i {
        transform: rotate(180deg);
        color: #0056b3;
    }

    /* Styling Konten Body */
    .accordion-body {
        max-height: 0;
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
    <h1>SYARAT & KETENTUAN</h1>
    <p>Harap baca syarat dan ketentuan kami dengan saksama sebelum menggunakan layanan kami.</p>
</section>

{{-- Konten Accordion --}}
<section class="faq-content container">
    <div class="accordion"> {{-- Class accordion utama --}}

        {{-- Item 1 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>1. Ketentuan Umum</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content"> {{-- Wrapper untuk padding --}}
                    <p>Dengan mengakses atau menggunakan situs web ini (eyetails.co), Anda setuju untuk terikat oleh
                        Syarat & Ketentuan ini. Jika Anda tidak setuju dengan bagian mana pun dari ketentuan ini, Anda
                        tidak diizinkan untuk menggunakan layanan kami.</p>
                    <p>Kami berhak untuk mengubah atau mengganti Ketentuan ini kapan saja. Tanggung jawab Anda untuk
                        memeriksa halaman ini secara berkala untuk perubahan.</p>
                </div>
            </div>
        </div>

        {{-- Item 2 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>2. Akun Pengguna</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content">
                    <p>Saat Anda membuat akun dengan kami, Anda harus memberikan informasi yang akurat, lengkap, dan
                        terkini. Kegagalan untuk melakukannya merupakan pelanggaran terhadap Ketentuan.</p>
                    <p>Anda bertanggung jawab untuk menjaga kerahasiaan kata sandi Anda. Anda setuju untuk tidak
                        mengungkapkan kata sandi Anda kepada pihak ketiga mana pun dan harus segera memberi tahu kami
                        jika mengetahui adanya pelanggaran keamanan atau penggunaan akun Anda tanpa izin.</p>
                </div>
            </div>
        </div>

        {{-- Item 3 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>3. Pemesanan dan Pembayaran</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content">
                    <p>Setiap pesanan yang Anda lakukan merupakan penawaran untuk membeli produk. Semua pesanan tunduk
                        pada ketersediaan dan konfirmasi harga pesanan.</p>
                    <p>Kami berhak menolak pesanan apa pun yang Anda lakukan. Kami dapat, atas kebijakan kami sendiri,
                        membatasi atau membatalkan jumlah yang dibeli per orang atau per pesanan.</p>
                    <p>Pembayaran harus diselesaikan melalui metode pembayaran yang tersedia di situs kami. Pesanan
                        hanya akan diproses setelah pembayaran divalidasi oleh sistem kami.</p>
                </div>
            </div>
        </div>

        {{-- Item 4 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>4. Harga dan Ketersediaan Produk</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content">
                    <p>Harga untuk produk kami dapat berubah tanpa pemberitahuan. Kami berhak setiap saat untuk
                        memodifikasi atau menghentikan produk apa pun tanpa pemberitahuan.</p>
                    <p>Stok produk di website kami ditampilkan secara *real-time* dan terintegrasi dengan sistem
                        inventaris kami. Namun, kesalahan ketersediaan stok dapat terjadi. Jika produk yang Anda pesan
                        tidak tersedia, kami akan menghubungi Anda untuk opsi penggantian atau pengembalian dana.</p>
                </div>
            </div>
        </div>

        {{-- Item 5 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>5. Kebijakan Pengembalian dan Penukaran</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content">
                    <p>Kami menerima penukaran ukuran (size) dalam waktu 7 hari setelah barang diterima, dengan syarat
                        kondisi produk 100% baru (belum dipakai, tag utuh, dan kemasan lengkap).</p>
                    <p>Biaya pengiriman untuk penukaran ukuran ditanggung sepenuhnya oleh pelanggan, kecuali jika
                        terjadi kesalahan dari pihak kami (salah kirim produk atau produk cacat).</p>
                    <p>Kami tidak menerima pengembalian dana (refund) untuk alasan perubahan pikiran.</p>
                </div>
            </div>
        </div>

        {{-- Item 6 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>6. Hak Kekayaan Intelektual</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content">
                    <p>Seluruh konten yang ada di situs ini, termasuk namun tidak terbatas pada teks, grafik, logo,
                        ikon, gambar, dan perangkat lunak, adalah milik eyetails.co atau pemasok kontennya dan
                        dilindungi oleh undang-undang hak cipta.</p>
                    <p>Penggunaan materi kami tanpa izin tertulis sebelumnya dilarang keras.</p>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

{{--
======================================================================
SCRIPT JAVASCRIPT ACCORDION
(Script yang sama dari halaman sebelumnya)
======================================================================
--}}
@push('scripts')
<script>
    function toggleAccordion(header) {
        header.classList.toggle('active');
        var body = header.nextElementSibling;
        if (body.style.maxHeight) {
            body.style.maxHeight = null;
        } else {
            var content = body.querySelector('.accordion-body-content');
            body.style.maxHeight = content.scrollHeight + "px";
        }
        document.querySelectorAll('.accordion-header').forEach(h => {
            if (h !== header && h.classList.contains('active')) {
                 h.classList.remove('active');
                 h.nextElementSibling.style.maxHeight = null;
            }
        });
    }

    window.addEventListener('resize', () => {
        document.querySelectorAll('.accordion-header.active').forEach(header => {
            var body = header.nextElementSibling;
            var content = body.querySelector('.accordion-body-content');
            body.style.maxHeight = content.scrollHeight + "px";
        });
    });
</script>
@endpush