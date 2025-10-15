<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Menampilkan daftar semua metode pembayaran.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::latest()->paginate(10);
        return view('admin.payments.index', compact('paymentMethods'));
    }

    /**
     * Menampilkan form untuk membuat metode pembayaran baru.
     */
    public function create()
    {
        return view('admin.payments.create');
    }

    /**
     * Menyimpan metode pembayaran baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validatedData['is_active'] = $request->has('is_active');

        PaymentMethod::create($validatedData);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Metode pembayaran baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit metode pembayaran.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payments.edit', compact('paymentMethod'));
    }

    /**
     * Memperbarui data metode pembayaran di database.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code,' . $paymentMethod->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validatedData['is_active'] = $request->has('is_active');

        $paymentMethod->update($validatedData);

        return redirect()->route('admin.payments.index')
            ->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    /**
     * Menghapus metode pembayaran dari database.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}
