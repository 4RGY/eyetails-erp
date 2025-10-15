<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReturnRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnRequestController extends Controller
{
    /**
     * Menampilkan daftar semua permintaan pengembalian/penukaran.
     */
    public function index()
    {
        $returnRequests = ReturnRequest::with(['user', 'order', 'orderItem'])->latest()->paginate(15);
        return view('admin.returns.index', compact('returnRequests'));
    }

    /**
     * Menampilkan detail satu permintaan.
     * PERUBAHAN: Menggunakan $id secara eksplisit.
     */
    public function show($id)
    {
        // Cari permintaan retur beserta semua relasinya.
        $returnRequest = ReturnRequest::with(['user', 'order', 'orderItem'])->findOrFail($id);

        return view('admin.returns.show', compact('returnRequest'));
    }

    /**
     * Memperbarui status permintaan (Approve/Reject) dan mengurangi poin.
     * PERUBAHAN: Menggunakan $id secara eksplisit.
     */
    public function update(Request $request, $id)
    {
        // Cari permintaan retur secara manual.
        $returnRequest = ReturnRequest::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Approved,Rejected,Processing,Completed',
            'admin_notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $oldStatus = $returnRequest->status;
            $newStatus = $request->status;

            $returnRequest->update([
                'status' => $newStatus,
                'admin_notes' => $request->admin_notes,
            ]);

            // Logika "sedot poin"
            if ($newStatus === 'Completed' && $oldStatus !== 'Completed') {
                if ($returnRequest->type === 'Return') {
                    $user = $returnRequest->user;
                    $item = $returnRequest->orderItem;
                    $pointsToDeduct = floor(($item->price * $item->quantity) / 10000);

                    if ($pointsToDeduct > 0 && $user) {
                        $user->loyalty_points = max(0, $user->loyalty_points - $pointsToDeduct);
                        $user->save();
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.returns.show', $returnRequest->id)
                ->with('success', 'Status permintaan pengembalian berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.returns.show', $returnRequest->id)
                ->with('error', 'Terjadi kesalahan saat memperbarui status.');
        }
    }
}
