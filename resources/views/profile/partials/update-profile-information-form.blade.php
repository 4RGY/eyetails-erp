<section class="profile-update-card">
    <header>
        <h2 class="profile-header">
            Informasi Profil & Alamat
        </h2>
        <p class="profile-subtitle">
            Perbarui informasi profil dan alamat pengiriman default Anda.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="profile-form">
        @csrf
        @method('patch')

        {{-- Form Group untuk Nama & Email --}}
        <div class="form-row">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input id="name" name="name" type="text" class="form-input" value="{{ old('name', $user->name) }}"
                    required autofocus autocomplete="name" />
                @error('name') <span class="error-message">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}"
                    required autocomplete="username" />
                @error('email') <span class="error-message">{{ $message }}</span> @enderror
            </div>
        </div>

        <hr class="form-divider">

        {{-- Form Group untuk Alamat & Telepon --}}
        <div class="form-row">
            {{-- <div class="form-group">
                <label for="phone">Nomor Telepon</label>
                <input id="phone" name="phone" type="text" class="form-input" value="{{ old('phone', $user->phone) }}">
                @error('phone') <span class="error-message">{{ $message }}</span> @enderror
            </div> --}}
            <div>
                <x-input-label for="phone" :value="__('Nomor Telepon')" />
                <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $user->phone)"
                    autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
            <div class="form-group">
                <label for="address">Alamat Pengiriman Utama</label>
                <textarea id="address" name="address" rows="3"
                    class="form-input">{{ old('address', $user->address) }}</textarea>
                @error('address') <span class="error-message">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">SIMPAN PERUBAHAN</button>
            @if (session('status') === 'profile-updated')
            <p class="text-sm text-gray-600">Tersimpan.</p>
            @endif
        </div>
    </form>
</section>