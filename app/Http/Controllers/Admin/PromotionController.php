<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Menampilkan daftar semua promo.
     */
    public function index()
    {
        $promotions = Promotion::latest()->paginate(15);
        return view('admin.promotions.index', compact('promotions'));
    }

    /**
     * Menampilkan form untuk membuat promo baru.
     */
    public function create()
    {
        return view('admin.promotions.create');
    }

    /**
     * Menyimpan promo baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|unique:promotions,code',
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        Promotion::create($request->all());

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promo baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit promo.
     */
    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    /**
     * Memperbarui data promo di database.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|unique:promotions,code,' . $promotion->id,
            'type' => 'required|in:percentage,fixed_amount',
            'value' => 'required|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'usage_limit' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $promotion->update($request->all());

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Data promo berhasil diperbarui.');
    }

    /**
     * Menghapus promo dari database.
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promo berhasil dihapus.');
    }
}
