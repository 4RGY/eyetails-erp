@extends('layouts.app')

@section('title', 'Testimoni | eyetails.co')

@section('content')

{{-- Header Halaman --}}
<section class="page-header container text-center">
    <h1>APA KATA MEREKA</h1>
    <p>Kisah dan pengalaman tulus dari pelanggan dan komunitas kami yang luar biasa.</p>
</section>

{{-- Grid Testimoni --}}
<section class="testimonial-section container">
    <div class="testimonial-grid">

        {{-- Kartu Testimoni 1 --}}
        <div class="testimonial-card">
            <div class="testimonial-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                    class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="testimonial-text">
                Kualitasnya benar-benar di atas ekspektasi. Hoodie yang saya beli bahannya tebal tapi tetap adem.
                Desainnya minimalis tapi keren, persis seperti yang saya cari.
            </p>
            <div class="testimonial-author">
                <img src="https://i.pravatar.cc/100?u=adi" alt="Foto Pelanggan" class="author-avatar">
                <div class="author-info">
                    <h3 class="author-name">Adi Prasetyo</h3>
                    <span class="author-role">Mahasiswa, Jakarta</span>
                </div>
            </div>
        </div>

        {{-- Kartu Testimoni 2 --}}
        <div class="testimonial-card">
            <div class="testimonial-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                    class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="testimonial-text">
                Proses order sampai pengiriman cepat sekali. Adminnya juga responsif waktu saya tanya soal ukuran. Pasti
                akan jadi langganan di sini. Two thumbs up!
            </p>
            <div class="testimonial-author">
                <img src="https://i.pravatar.cc/100?u=siti" alt="Foto Pelanggan" class="author-avatar">
                <div class="author-info">
                    <h3 class="author-name">Siti Nurhaliza</h3>
                    <span class="author-role">Graphic Designer, Bandung</span>
                </div>
            </div>
        </div>

        {{-- Kartu Testimoni 3 --}}
        <div class="testimonial-card">
            <div class="testimonial-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                    class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <p class="testimonial-text">
                Suka banget sama koleksi kolaborasinya. Unik dan beda dari yang lain. Packaging-nya juga niat banget,
                terasa eksklusif. Recommended!
            </p>
            <div class="testimonial-author">
                <img src="https://i.pravatar.cc/100?u=budi" alt="Foto Pelanggan" class="author-avatar">
                <div class="author-info">
                    <h3 class="author-name">Budi Santoso</h3>
                    <span class="author-role">Fotografer, Surabaya</span>
                </div>
            </div>
        </div>

        {{-- Kartu Testimoni 4 --}}
        <div class="testimonial-card">
            <div class="testimonial-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                    class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="testimonial-text">
                Akhirnya nemu brand lokal yang cutting-annya pas di badan. Gak nyesel beli T-shirt dan celananya.
                Bahannya juga nyaman buat aktivitas seharian.
            </p>
            <div class="testimonial-author">
                <img src="https://i.pravatar.cc/100?u=dewi" alt="Foto Pelanggan" class="author-avatar">
                <div class="author-info">
                    <h3 class="author-name">Dewi Lestari</h3>
                    <span class="author-role">Content Creator</span>
                </div>
            </div>
        </div>

        {{-- Kartu Testimoni 5 --}}
        <div class="testimonial-card">
            <div class="testimonial-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                    class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="testimonial-text">
                Program loyalitasnya a-ma-zing! Poinnya gampang dikumpulin dan diskonnya beneran kerasa. Bikin makin
                semangat belanja di eyetails.co.
            </p>
            <div class="testimonial-author">
                <img src="https://i.pravatar.cc/100?u=eko" alt="Foto Pelanggan" class="author-avatar">
                <div class="author-info">
                    <h3 class="author-name">Eko Wibowo</h3>
                    <span class="author-role">Gold Tier Member</span>
                </div>
            </div>
        </div>

        {{-- Kartu Testimoni 6 --}}
        <div class="testimonial-card">
            <div class="testimonial-rating">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                    class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="testimonial-text">
                Dari semua brand streetwear yang pernah saya coba, eyetails punya kualitas jahit terbaik. Rapi dan kuat.
                Terlihat jelas kalau dibuat dengan detail.
            </p>
            <div class="testimonial-author">
                <img src="https://i.pravatar.cc/100?u=rina" alt="Foto Pelanggan" class="author-avatar">
                <div class="author-info">
                    <h3 class="author-name">Rina Marlina</h3>
                    <span class="author-role">Pengusaha, Medan</span>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection