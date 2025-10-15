<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInteraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CrmController extends Controller
{
    /**
     * Menampilkan halaman utama CRM dengan daftar pelanggan.
     */
    public function index(Request $request)
    {
        $query = User::where('is_admin', false) // Hanya tampilkan pelanggan, bukan admin
            ->withCount('orders')
            ->withSum('orders', 'total_amount');

        // Fitur Pencarian
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        $customers = $query->latest()->paginate(20);

        // Data untuk Analisis Sederhana
        $customerStats = [
            'total_customers' => User::where('is_admin', false)->count(),
            'new_customers_this_month' => User::where('is_admin', false)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count(),
            'total_revenue' => DB::table('orders')->where('order_status', 'Completed')->sum('total_amount'),
        ];


        return view('admin.crm.index', compact('customers', 'customerStats'));
    }

    /**
     * Menampilkan detail satu pelanggan.
     */
    public function show(User $customer)
    {
        // Pastikan tidak mengakses data admin lain
        if ($customer->is_admin) {
            abort(404);
        }

        $customer->load(['orders' => function ($query) {
            $query->latest()->take(10); // Ambil 10 pesanan terakhir
        }, 'interactions.admin']);

        return view('admin.crm.show', compact('customer'));
    }

    /**
     * Menambahkan catatan interaksi baru untuk pelanggan.
     */
    public function addInteraction(Request $request, User $customer)
    {
        $request->validate([
            'channel' => 'required|string|max:255',
            'notes' => 'required|string',
        ]);

        $customer->interactions()->create([
            'admin_id' => Auth::id(),
            'channel' => $request->channel,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.crm.show', $customer)
            ->with('success', 'Catatan interaksi berhasil ditambahkan.');
    }

    /**
     * Memperbarui status pelanggan.
     */
    public function updateStatus(Request $request, User $customer)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $customer->update(['status' => $request->status]);

        return redirect()->route('admin.crm.show', $customer)
            ->with('success', 'Status pelanggan berhasil diperbarui.');
    }
}
