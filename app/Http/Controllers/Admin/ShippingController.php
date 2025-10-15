<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod; // <-- 1. Import model yang sudah kita buat
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Menampilkan daftar semua metode pengiriman.
     */
    public function index()
    {
        $shippingMethods = ShippingMethod::latest()->paginate(10);
        return view('admin.shipping.index', compact('shippingMethods'));
    }

    /**
     * Menampilkan form untuk membuat metode pengiriman baru.
     */
    public function create()
    {
        return view('admin.shipping.create');
    }

    /**
     * Menyimpan metode pengiriman baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        // Pastikan nilai boolean selalu ada (0 jika checkbox tidak dicentang)
        $validatedData['is_active'] = $request->has('is_active');

        ShippingMethod::create($validatedData);

        return redirect()->route('admin.shipping.index')
            ->with('success', 'Metode pengiriman baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit metode pengiriman.
     */
    public function edit(ShippingMethod $shippingMethod)
    {
        return view('admin.shipping.edit', compact('shippingMethod'));
    }

    /**
     * Memperbarui data metode pengiriman di database.
     */
    public function update(Request $request, ShippingMethod $shippingMethod)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $validatedData['is_active'] = $request->has('is_active');

        $shippingMethod->update($validatedData);

        return redirect()->route('admin.shipping.index')
            ->with('success', 'Metode pengiriman berhasil diperbarui.');
    }

    /**
     * Menghapus metode pengiriman dari database.
     */
    public function destroy(ShippingMethod $shippingMethod)
    {
        $shippingMethod->delete();

        return redirect()->route('admin.shipping.index')
            ->with('success', 'Metode pengiriman berhasil dihapus.');
    }
}
