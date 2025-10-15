<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminChatController extends Controller
{
    /**
     * Menampilkan daftar semua percakapan (inbox admin).
     */
    public function index()
    {
        // Ambil semua percakapan, urutkan berdasarkan yang belum dibaca dan balasan terbaru
        $conversations = Conversation::with('user', 'product')
            ->orderBy('is_read_by_admin', 'asc')
            ->latest('last_reply_at')
            ->paginate(15);

        return view('admin.chat.index', compact('conversations'));
    }

    /**
     * Menampilkan detail satu percakapan untuk dibalas oleh admin.
     */
    public function show(Conversation $conversation)
    {
        $conversation->load('messages.user', 'product', 'user');

        // Tandai bahwa admin telah membaca percakapan ini
        if (!$conversation->is_read_by_admin) {
            $conversation->update(['is_read_by_admin' => true]);
        }

        return view('admin.chat.show', compact('conversation'));
    }

    /**
     * Menyimpan balasan dari admin.
     */
    public function sendMessage(Request $request, Conversation $conversation)
    {
        $request->validate(['body' => 'required|string']);

        // Pesan dibuat oleh admin yang sedang login
        $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        // Update waktu balasan terakhir
        $conversation->update([
            'last_reply_at' => now(),
        ]);

        // Di sini Anda bisa menambahkan notifikasi email ke pengguna jika diperlukan

        return redirect()->route('admin.chat.show', $conversation);
    }
}
