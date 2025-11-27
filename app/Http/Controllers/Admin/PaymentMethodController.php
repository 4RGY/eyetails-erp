<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        // Mengirim variabel $paymentMethods ke view
        $paymentMethods = PaymentMethod::latest()->paginate(10);
        return view('admin.payments.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('admin.payments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);
        $validated['is_active'] = $request->has('is_active');
        PaymentMethod::create($validated);
        return redirect()->route('admin.payments.index')->with('success', 'Metode pembayaran berhasil dibuat.');
    }

    // PENTING: Menggunakan variabel $payment agar cocok dengan route {payment}
    public function edit(PaymentMethod $payment)
    {
        // Mengirim variabel 'payment' ke view
        return view('admin.payments.edit', compact('payment'));
    }

    // PENTING: Menggunakan variabel $payment agar cocok dengan route {payment}
    public function update(Request $request, PaymentMethod $payment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:payment_methods,code,' . $payment->id,
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $payment->update($validated);

        return redirect()->route('admin.payments.index')->with('success', 'Metode pembayaran berhasil diperbarui.');
    }

    // PENTING: Menggunakan variabel $payment agar cocok dengan route {payment}
    public function destroy(PaymentMethod $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payments.index')->with('success', 'Metode pembayaran berhasil dihapus.');
    }
}
