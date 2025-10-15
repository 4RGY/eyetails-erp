<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactUsMail;


class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // 1. Validasi Data Input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // 2. Kirim Email ke Admin
        try {
            // Ganti 'admin@eyetails.co' dengan email penerima sebenarnya
            Mail::to('rgyanggara@gmail.com')->send(new ContactUsMail($validatedData));

            return redirect('/kontak-kami')->with('success', 'Pesan Anda berhasil terkirim! Kami akan segera merespons.');
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Mail Error: ' . $e->getMessage());
            return redirect('/kontak-kami')->with('error', 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi nanti.');
        }
    }
}
