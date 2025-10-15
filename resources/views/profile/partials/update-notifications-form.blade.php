<section class="profile-update-card">
    <header>
        <h2 class="profile-header">Preferensi Notifikasi</h2>
        <p class="profile-subtitle">Pilih jenis notifikasi email yang ingin Anda terima.</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="profile-form">
        @csrf
        @method('patch')

        <div class="form-group">
            <label class="toggle-switch">
                {{-- Checkbox ini akan mengirim nilai '1' jika dicentang --}}
                <input type="checkbox" name="notif_promo" value="1" {{ old('notif_promo', $user->notif_promo) ?
                'checked' : '' }}>
                <span class="slider"></span>
                <span class="label-text">Info Promo & Diskon</span>
            </label>
            <p class="toggle-description">Dapatkan email tentang penawaran spesial, produk baru, dan diskon eksklusif.
            </p>
        </div>

        <div class="form-group">
            <label class="toggle-switch">
                <input type="checkbox" name="notif_order_updates" value="1" {{ old('notif_order_updates',
                    $user->notif_order_updates) ? 'checked' : '' }}>
                <span class="slider"></span>
                <span class="label-text">Pembaruan Status Pesanan</span>
            </label>
            <p class="toggle-description">Terima email konfirmasi saat pesanan dibuat, dikirim, dan selesai.</p>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">SIMPAN PREFERENSI</button>
        </div>
    </form>
</section>

{{--
CSS ini khusus untuk membuat toggle switch terlihat bagus.
Kita push ke stack 'styles' agar digabungkan dengan CSS lain di layout utama.
--}}
@push('styles')
<style>
    .toggle-switch {
        position: relative;
        display: inline-flex;
        align-items: center;
        width: 100%;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
        /* Mencegah highlight biru di mobile */
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: relative;
        width: 44px;
        height: 24px;
        background-color: #ccc;
        border-radius: 34px;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        border-radius: 50%;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: var(--primary-accent, #4f46e5);
    }

    input:checked+.slider:before {
        transform: translateX(20px);
    }

    .label-text {
        margin-left: 12px;
        /* Jarak antara slider dan teks */
        font-weight: 600;
        color: #333;
    }

    .toggle-description {
        font-size: .9rem;
        color: #6c757d;
        margin-top: .5rem;
        padding-left: 56px;
        /* (lebar slider + margin-left) */
    }
</style>
@endpush