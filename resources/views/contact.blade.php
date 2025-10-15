@extends('layouts.app')

@section('title', 'Kontak Kami | eyetails.co')

@section('content')

<section class="page-header container text-center">
    <h1>KONTAK KAMI</h1>
    <p>Kami siap mendengarkan pertanyaan, masukan, atau permintaan kerja sama dari Anda. Kami akan merespons dalam waktu
        1x24 jam.</p>
</section>

<section class="contact-content container">

    <div class="contact-form-area">
        <h2>Kirim Pesan</h2>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('contact.submit') }}" method="POST" class="contact-form">
            @csrf

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" placeholder="Masukkan Nama Anda" required
                    value="{{ old('name') }}">
                @error('name') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan Email Anda" required
                    value="{{ old('email') }}">
                @error('email') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="message">Pesan Anda</label>
                <textarea id="message" name="message" rows="5" placeholder="Tuliskan Pesan Anda di sini"
                    required>{{ old('message') }}</textarea>
                @error('message') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">KIRIM PESAN</button>
        </form>
    </div>

    <div class="contact-info">
        <h2>Informasi</h2>
        <div class="info-item">
            <i class="fas fa-map-marker-alt"></i>
            <div>
                <h3>ALAMAT PUSAT</h3>
                <p>{{ $siteSettings['address'] ?? 'Alamat belum diatur' }}</p>
            </div>
        </div>
        <div class="info-item">
            <i class="fas fa-phone-alt"></i>
            <div>
                <h3>TELEPON</h3>
                <p>{{ $siteSettings['default_phone'] ?? 'Telepon belum diatur' }}</p>
            </div>
        </div>
        <div class="info-item">
            <i class="fas fa-envelope"></i>
            <div>
                <h3>EMAIL LAYANAN</h3>
                <p>{{ $siteSettings['default_email'] ?? 'Email belum diatur' }}</p>
            </div>
        </div>
    </div>
</section>

<section class="location-map">
    <h2>Peta Lokasi Kami</h2>
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.303901967261!2d106.81222471476884!3d-6.223871495493026!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3d5b2c9b2d3%3A0x6b7b3e1b2f9f1f0a!2sUniversitas%20Indraprasta%20PGRI%20Kampus%20A!5e0!3m2!1sid!2sid!4v1633000000000!5m2!1sid!2sid"
        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</section>

@endsection