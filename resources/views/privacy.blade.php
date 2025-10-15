@extends('layouts.app')

@section('title', 'Kebijakan Privasi | eyetails.co')

@section('content')

<section class="page-header container text-center">
    <h1>KEBIJAKAN PRIVASI</h1>
    <p>Komitmen kami untuk melindungi data dan privasi Anda. Terakhir diperbarui: 2 Oktober 2025.</p>
</section>

<section class="faq-content container">
    <div class="accordion">

        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                1. Jenis Informasi Pribadi yang Kami Kumpulkan
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="content-block">
                    <p>Kami mengumpulkan data yang Anda berikan langsung saat:
                    <ul>
                        <li>**Pembuatan Akun Dasar:** Nama, alamat email, dan kata sandi terenkripsi.</li>
                        <li>**Transaksi:** Alamat pengiriman (Manajemen Pengiriman), detail kontak, dan riwayat pesanan
                            (Manajemen Pesanan).</li>
                        <li>**Loyalitas:** Data pembelian untuk menghitung Poin Loyalitas dan status Tier (Fitur
                            Unggulan A & B).</li>
                    </ul>
                    </p>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                2. Tujuan Penggunaan Informasi Anda
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="content-block">
                    <p>Data Anda digunakan untuk tujuan operasional dan analitis, termasuk:
                    <ul>
                        <li>**Pemrosesan Pesanan:** Mengintegrasikan data transaksi dengan Modul Keuangan (Pencatatan
                            Penjualan) dan Modul Inventaris (Sinkronisasi Stok) di ERP.</li>
                        <li>**Layanan Pelanggan:** Mengelola akun Anda melalui Manajemen Pelanggan di *backend*.</li>
                        <li>**Program Loyalitas:** Menentukan dan memperbarui status Tier Anda.</li>
                        <li>**Pemasaran:** Mengirimkan informasi promosi/diskon, hanya jika Anda telah menyetujuinya.
                        </li>
                    </ul>
                    </p>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                3. Keamanan dan Penyimpanan Data
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="content-block">
                    <p>Kami menggunakan enkripsi (hashing) untuk kata sandi dan menerapkan langkah-langkah keamanan
                        fisik serta elektronik. Data Anda disimpan di server yang aman. Akses ke data pelanggan di sisi
                        Admin dibatasi sesuai Hak Akses yang ketat.</p>
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <button class="accordion-header" onclick="toggleAccordion(this)">
                4. Hak Anda atas Data Pribadi Anda
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="accordion-body">
                <div class="content-block">
                    <p>Anda berhak untuk mengakses, memperbaiki, atau menghapus data pribadi Anda melalui Halaman
                        Pengaturan Profil. Untuk permintaan penghapusan akun permanen, silakan hubungi tim dukungan
                        kami.</p>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
    // Fungsi toggleAccordion sama persis dengan yang ada di FAQ dan Terms, 
    // memastikan tampilan tetap smooth.
    function toggleAccordion(header) {
        header.classList.toggle('active');
        
        var body = header.nextElementSibling;
        
        if (body.style.maxHeight) {
            body.style.maxHeight = null;
        } else {
            body.style.maxHeight = body.scrollHeight + "px";
        }
        
        document.querySelectorAll('.accordion-header').forEach(h => {
            if (h !== header && h.classList.contains('active')) {
                 h.classList.remove('active');
                 h.nextElementSibling.style.maxHeight = null;
            }
        });
    }
</script>
@endpush