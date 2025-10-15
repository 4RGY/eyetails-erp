<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleProviderCallback()
    {
        try {
            // =======================================================
            // PERBAIKAN: HAPUS ->stateless() DARI BARIS INI
            // =======================================================
            $socialUser = Socialite::driver('google')->user();

            // Cek apakah user dengan email ini sudah ada
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // Jika user sudah ada, update provider_id jika kosong dan login-kan
                $user->update([
                    'provider_name' => 'google',
                    'provider_id'   => $socialUser->getId(),
                ]);
            } else {
                // Jika user belum ada, buat user baru
                $user = User::create([
                    'name'          => $socialUser->getName(),
                    'email'         => $socialUser->getEmail(),
                    'provider_name' => 'google',
                    'provider_id'   => $socialUser->getId(),
                    'email_verified_at' => now(), // Anggap email sudah terverifikasi oleh Google
                    'password'      => Hash::make(Str::random(16)) // Buat password acak karena tidak diperlukan
                ]);
            }

            // Login-kan user ke sistem
            Auth::login($user);

            // Redirect ke dashboard
            return redirect('/dashboard');
        } catch (\Exception $e) {
            // Jika ada error, kembalikan ke halaman login dengan pesan error
            return redirect('/login')->with('error', 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi.');
        }
    }
}
