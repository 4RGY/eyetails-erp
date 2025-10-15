@extends('layouts.app')

@section('title', 'Syarat dan Ketentuan | eyetails.co')

@section('content')

<section class="page-header container text-center">
    <h1>SYARAT DAN KETENTUAN PENGGUNAAN</h1>
    <p>Terakhir diperbarui: 2 Oktober 2025. Dengan menggunakan layanan kami, Anda menyetujui ketentuan ini.</p>
</section>

<section class="faq-content container">
    <div class="accordion">

        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                1. Persyaratan Akun dan Pendaftaran
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="content-block">
                    <p>Untuk mengakses beberapa fitur *e-commerce* (seperti Wishlist, Order History, dan Program
                        Loyalitas), Anda diwajibkan membuat akun. Anda bertanggung jawab penuh atas keamanan kata sandi
                        Anda. Semua data pengguna dikelola melalui Modul Manajemen Pelanggan di *backend* Admin.</p>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                2. Ketentuan Pembelian dan Ketersediaan Stok
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="content-block">
                    <p>Semua harga yang tertera adalah harga final. Pembelian dianggap sah setelah pembayaran
                        terverifikasi. Ketersediaan stok produk bersifat *real-time* karena terintegrasi dengan Modul
                        Inventaris di ERP. Jika terjadi kesalahan stok (meskipun jarang), kami akan segera menghubungi
                        Anda.</p>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                3. Prosedur Pengiriman dan Logistik
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="content-block">
                    <p>Biaya pengiriman dihitung berdasarkan alamat dan metode pengiriman yang Anda pilih (Modul
                        Manajemen Pengiriman). Setelah pesanan dikonfirmasi, status pengiriman dikelola hingga barang
                        sampai ke tangan Anda melalui sistem Logistik terintegrasi kami. Resiko kehilangan atau
                        kerusakan setelah barang diserahkan kepada kurir menjadi tanggung jawab pihak kurir.</p>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                4. Kebijakan Pengembalian dan Penukaran Produk
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="content-block">
                    <p>Anda memiliki hak untuk mengajukan pengembalian atau penukaran dalam waktu 7 hari, sesuai dengan
                        syarat dan ketentuan Modul Manajemen Pengembalian & Penukaran (Admin). Produk harus dalam
                        kondisi asli, belum digunakan, dan tag masih terpasang.</p>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                5. Batasan Tanggung Jawab dan Hukum yang Berlaku
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="content-block">
                    <p>Dalam batas maksimal yang diizinkan oleh hukum, eyetails.co tidak bertanggung jawab atas
                        kerusakan atau kerugian tidak langsung. Syarat dan Ketentuan ini diatur dan ditafsirkan sesuai
                        dengan hukum Republik Indonesia.</p>
                </div>
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