@extends('layouts.app')

@section('title', 'FAQ | eyetails.co')

@section('content')

<section class="page-header container text-center">
    <h1>PERTANYAAN YANG SERING DIAJUKAN (FAQ)</h1>
    <p>Temukan jawaban cepat mengenai pemesanan, pengiriman, dan Program Loyalitas eksklusif kami.</p>
</section>

<section class="faq-content container">
    <div class="accordion">

        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                Bagaimana cara saya mendapatkan Poin Loyalitas dan menaikkan Tier saya?
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <p>Poin Loyalitas (Fitur Unggulan A) diperoleh setiap kali Anda melakukan pembelian di situs
                    eyetails.co. Poin akan tercatat otomatis di akun Anda dan disinkronkan dengan sistem ERP kami[cite:
                    8, 11]. Untuk menaikkan Tier (Bronze, Silver, Gold - Fitur Unggulan B), total pembelanjaan Anda akan
                    diakumulasikan. Semakin tinggi Tier, semakin besar diskon dan hak akses eksklusif yang Anda
                    dapatkan.</p>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                Apakah stok produk di website akurat?
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <p>Ya. Stok yang ditampilkan adalah *real-time* karena sistem *e-commerce* kami terintegrasi kritis
                    dengan Modul Inventaris di ERP[cite: 11, 87]. Setiap penjualan yang terjadi di *frontend* akan
                    secara otomatis mengurangi stok di *backend*[cite: 87], memastikan akurasi pesanan Anda.</p>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                Apakah saya bisa menukar produk jika ukurannya tidak pas?
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <p>Ya, kami menerima penukaran ukuran dalam waktu 7 hari setelah barang diterima, selama produk masih
                    dalam kondisi asli. Semua proses penukaran dikelola melalui sistem Logistik (Manajemen Pengiriman)
                    dan Manajemen Pengembalian di *backend* Admin[cite: 8, 88].</p>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                Bagaimana transaksi saya dicatat dan diamankan?
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <p>Setiap transaksi pembelian yang sukses akan dicatat dan disinkronkan secara otomatis ke Laporan
                    Keuangan Dasar di sistem ERP kami (Pencatatan Penjualan)[cite: 11, 89]. Kami menjamin keamanan data
                    pembayaran Anda, yang dikelola oleh Modul Manajemen Pembayaran[cite: 8].</p>
            </div>
        </div>

    </div>
</section>

@endsection

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
            body.style.maxHeight = body.scrollHeight + "px";
        }
        
        // Opsional: Tutup item lain
        document.querySelectorAll('.accordion-header').forEach(h => {
            if (h !== header && h.classList.contains('active')) {
                 h.classList.remove('active');
                 h.nextElementSibling.style.maxHeight = null;
            }
        });
    }
</script>
@endpush