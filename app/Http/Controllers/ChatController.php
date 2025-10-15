<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        // Pastikan hanya user yang sudah login yang bisa mengakses fitur ini
        $this->middleware('auth');
    }

    /**
     * Menampilkan daftar semua percakapan milik pengguna.
     */
    public function index()
    {
        $user = Auth::user();
        $conversations = $user->conversations()->with('product')->latest('last_reply_at')->paginate(10);

        return view('chat.index', compact('conversations'));
    }

    /**
     * Menampilkan detail satu percakapan dan pesannya.
     */
    public function show(Conversation $conversation)
    {
        // Pastikan user hanya bisa melihat percakapannya sendiri
        if ($conversation->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $conversation->load('messages.user', 'product');

        return view('chat.show', compact('conversation'));
    }

    /**
     * Menyimpan pesan baru dari pengguna.
     */
    public function sendMessage(Request $request, Conversation $conversation)
    {
        if ($conversation->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $request->validate(['body' => 'required|string']);

        $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        // Update waktu balasan terakhir untuk sorting
        $conversation->update([
            'last_reply_at' => now(),
            'is_read_by_admin' => false, // Tandai sebagai belum dibaca oleh admin
        ]);

        return redirect()->route('chat.show', $conversation);
    }

    /**
     * Membuat percakapan baru terkait produk.
     */
    public function startConversation(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'message' => 'required|string|min:10',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Buat percakapan baru
        $conversation = Conversation::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'subject' => 'Pertanyaan mengenai produk: ' . $product->name,
            'last_reply_at' => now(),
        ]);

        // Tambahkan pesan pertama ke percakapan
        $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $request->message,
        ]);

        return redirect()->route('chat.show', $conversation)
            ->with('success', 'Pesan Anda telah terkirim. Admin akan segera merespons.');
    }
}
