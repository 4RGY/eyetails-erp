{{-- resources/views/privacy.blade.php --}}

@extends('layouts.app')

@section('title', 'Kebijakan Privasi | eyetails.co')

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
    <h1>KEBIJAKAN PRIVASI</h1>
    <p>Privasi Anda penting bagi kami. Berikut cara kami mengumpulkan dan melindungi data Anda.</p>
</section>

{{-- Konten Accordion --}}
<section class="faq-content container">
    <div class="accordion"> {{-- Class accordion utama --}}

        {{-- Item 1 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>1. Komitmen Kami Terhadap Privasi Anda</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content"> {{-- Wrapper untuk padding --}}
                    <p>eyetails.co ("kami") berkomitmen untuk melindungi privasi data pribadi Anda. Kebijakan ini
                        menjelaskan jenis informasi pribadi yang kami kumpulkan, bagaimana kami menggunakannya, dan
                        langkah-langkah yang kami ambil untuk melindunginya.</p>
                </div>
            </div>
        </div>

        {{-- Item 2 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>2. Data Apa yang Kami Kumpulkan?</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content">
                    <p>Kami mengumpulkan data yang Anda berikan secara langsung saat Anda:</p>
                    <ul>
                        <li>Membuat akun (Nama, email, kata sandi).</li>
                        <li>Melakukan pemesanan (Alamat pengiriman, nomor telepon).</li>
                        <li>Menghubungi layanan pelanggan kami.</li>
                    </ul>
                    <p>Kami juga dapat mengumpulkan data teknis secara otomatis, seperti alamat IP, jenis browser, dan
                        halaman yang Anda kunjungi, untuk meningkatkan pengalaman berbelanja Anda.</p>
                </div>
            </div>
        </div>

        {{-- Item 3 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>3. Bagaimana Kami Menggunakan Data Anda?</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content">
                    <p>Data Anda kami gunakan untuk tujuan berikut:</p>
                    <ul>
                        <li>Memproses pesanan Anda, mulai dari pembayaran hingga pengiriman.</li>
                        <li>Memberikan layanan pelanggan dan menanggapi pertanyaan Anda.</li>
                        <li>Mengelola akun dan Program Loyalitas Anda.</li>
                        <li>Mengirimkan informasi promosi (jika Anda setuju untuk menerimanya).</li>
                        <li>Menganalisis data untuk meningkatkan layanan dan tata letak situs web kami.</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Item 4 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>4. Pembagian Informasi dengan Pihak Ketiga</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content">
                    <p>Kami tidak menjual data pribadi Anda kepada pihak ketiga. Kami hanya membagikan data Anda kepada
                        pihak ketiga yang penting untuk menjalankan layanan kami, yaitu:</p>
                    <ul>
                        <li><strong>Mitra Logistik (Kurir):</strong> Untuk mengirimkan pesanan ke alamat Anda.</li>
                        <li><strong>Penyedia Gerbang Pembayaran (Payment Gateway):</strong> Untuk memproses transaksi
                            Anda.</li>
                    </ul>
                    <p>Semua mitra kami terikat oleh perjanjian kerahasiaan untuk melindungi data Anda.</p>
                </div>
            </div>
        </div>

        {{-- Item 5 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>5. Keamanan Data Anda</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content">
                    <p>Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang wajar untuk melindungi data
                        pribadi Anda dari kehilangan, penyalahgunaan, atau akses tidak sah. Ini termasuk penggunaan
                        enkripsi SSL untuk transaksi data sensitif.</p>
                </div>
            </div>
        </div>

        {{-- Item 6 --}}
        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                <span>6. Hak Anda Atas Data Anda</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="accordion-body-content">
                    <p>Anda berhak untuk mengakses, memperbaiki, atau menghapus data pribadi yang kami simpan tentang
                        Anda. Anda dapat mengelola sebagian besar informasi Anda langsung melalui halaman 'Akun Saya'
                        atau dengan menghubungi layanan pelanggan kami.</p>
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