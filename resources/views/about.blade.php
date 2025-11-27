@extends('layouts.app')

@section('title', 'Tentang Kami | eyetails.co')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

{{-- Hero Section --}}
<section class="about-hero">
    <div class="container hero-content">
        <span class="eyetails-tagline">DEFINING MODERN MINIMALISM.</span>
        <h1>BUKAN SEKADAR PAKAIAN, TAPI SEBUAH PERNYATAAN.</h1>
        <p>Kami percaya pakaian terbaik haruslah fungsional, tahan lama, dan mendefinisikan Anda tanpa berteriak. Kami
            menciptakan koleksi yang minimalis dalam desain, namun maksimal dalam dampak.</p>
    </div>
</section>

{{-- Brand Story Section --}}
<section class="brand-story-section container">
    <div class="story-item story-vision">
        <div class="story-text">
            <h2>VISI KAMI</h2>
            <p>Menjadi merek gaya hidup urban terkemuka yang diakui secara global, memimpin dalam inovasi desain
                berkelanjutan dan membangun komunitas yang kuat melalui pengalaman digital yang terintegrasi penuh.</p>
        </div>
        <div class="story-visual">
            <img src="https://plus.unsplash.com/premium_photo-1664202526075-7436b5325ef3?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&q=80&w=687"
                alt="Visi Perusahaan">
        </div>
    </div>

    <div class="story-item story-mission">
        <div class="story-visual">
            <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?fit=crop&w=800&q=80"
                alt="Misi Perusahaan">
        </div>
        <div class="story-text">
            <h2>MISI KAMI</h2>
            <ul>
                <li>Menyediakan produk fashion premium dengan harga yang kompetitif.</li>
                <li>Mengintegrasikan proses bisnis yang efisien untuk layanan pelanggan optimal.</li>
                <li>Menciptakan desain yang unik, modern, dan selalu mengikuti tren pasar.</li>
                <li>Membangun program loyalitas yang memberikan nilai eksklusif.</li>
            </ul>
        </div>
    </div>
</section>

{{-- Philosophy Section --}}
<section class="philosophy-section">
    <div class="container">
        <div class="section-header">
            <h2>Filosofi Kami</h2>
        </div>
        <div class="philosophy-grid">
            <div class="philosophy-item">
                <i class="fas fa-gem"></i>
                <h3>KUALITAS DI ATAS KUANTITAS</h3>
                <p>Setiap jahitan, setiap bahan, dipilih dengan cermat untuk memastikan produk kami tidak hanya terlihat
                    bagus, tapi juga bertahan lama.</p>
            </div>
            <div class="philosophy-item">
                <i class="fas fa-palette"></i>
                <h3>DESAIN YANG BERBICARA</h3>
                <p>Kami percaya pada kekuatan desain minimalis. Pakaian kami dirancang untuk melengkapi, bukan
                    mendominasi, gaya personal Anda.</p>
            </div>
            <div class="philosophy-item">
                <i class="fas fa-users"></i>
                <h3>DIDUKUNG OLEH KOMUNITAS</h3>
                <p>Eyetails.co lebih dari sekadar brand. Kami adalah komunitas yang didukung oleh sistem terintegrasi
                    untuk memberikan Anda pengalaman terbaik.</p>
            </div>
        </div>
    </div>
</section>

@endsection