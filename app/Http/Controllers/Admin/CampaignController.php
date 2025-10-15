<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\PromotionalEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // <-- 1. Tambahkan use Log
use Illuminate\Support\Facades\Mail;

class CampaignController extends Controller
{
    /**
     * Menampilkan form untuk membuat email campaign baru.
     */
    public function create()
    {
        $subscriberCount = User::where('is_admin', false)
                                ->where('notif_promo', true)
                                ->count();

        return view('admin.campaigns.create', compact('subscriberCount'));
    }

    /**
     * Mengirim email campaign ke semua subscriber.
     */
    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string|min:20',
        ]);

        $subscribers = User::where('is_admin', false)
                           ->where('notif_promo', true)
                           ->get();

        if ($subscribers->isEmpty()) {
            return redirect()->route('admin.campaigns.create')->with('error', 'Tidak ada pelanggan yang berlangganan notifikasi promo.');
        }

        // =======================================================
        // LOGIKA BARU DENGAN ERROR HANDLING & COUNTER
        // =======================================================
        $sentCount = 0; // Buat penghitung email terkirim

        foreach ($subscribers as $user) {
            try {
                Mail::to($user->email)->send(new PromotionalEmail($request->subject, $request->content));
                $sentCount++; // Tambah 1 jika berhasil
            } catch (\Exception $e) {
                // Jika email gagal, catat errornya ke file log untuk kita periksa
                Log::error('Gagal mengirim email promo ke ' . $user->email . ': ' . $e->getMessage());
            }
        }

        // Berikan notifikasi berdasarkan jumlah email yang benar-benar terkirim
        if ($sentCount > 0) {
            return redirect()->route('admin.campaigns.create')->with('success', 'Email promo berhasil dikirim ke ' . $sentCount . ' pelanggan.');
        } else {
            return redirect()->route('admin.campaigns.create')->with('error', 'Gagal mengirim email promo. Silakan cek file log untuk detailnya.');
        }
        // =======================================================
    }
}