<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // =======================================================
        // LOGIKA BARU UNTUK MENANGANI SEMUA INPUT
        // =======================================================

        // Ambil semua data yang sudah tervalidasi
        $validatedData = $request->validated();

        // Karena checkbox yang tidak dicentang tidak mengirimkan nilai,
        // kita atur nilainya secara manual di sini.
        // Jika ada 'notif_promo' di request, nilainya true. Jika tidak, false.
        $validatedData['notif_promo'] = $request->has('notif_promo');
        $validatedData['notif_order_updates'] = $request->has('notif_order_updates');

        // Isi semua data ke model user
        $request->user()->fill($validatedData);

        // =======================================================

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
