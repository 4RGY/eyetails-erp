<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippingOptions = ShippingMethod::latest()->paginate(10);
        return view('admin.shipping.index', compact('shippingOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        // Set default is_active jika tidak ada di request
        $validated['is_active'] = $request->has('is_active');

        ShippingMethod::create($validated);

        return redirect()->route('admin.shipping.index')
            ->with('success', 'Metode pengiriman berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingMethod $shippingOption)
    {
        return view('admin.shipping.edit', compact('shippingOption'));
    }

    /**
     * Update the specified resource in storage.
     * INI BAGIAN YANG PALING PENTING UNTUK ANDA PERIKSA
     */
    public function update(Request $request, ShippingMethod $shippingOption)
    {
        // 1. Validasi input dari form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean', // is_active sekarang required karena kita mengirim 0 atau 1
        ]);

        // 2. Update model dengan data yang sudah divalidasi
        $shippingOption->update($validated);

        // 3. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.shipping.index')
            ->with('success', 'Metode pengiriman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingMethod $shippingOption)
    {
        $shippingOption->delete();

        return redirect()->route('admin.shipping.index')
            ->with('success', 'Metode pengiriman berhasil dihapus.');
    }
}
