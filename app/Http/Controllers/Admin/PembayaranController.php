<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PembayaranFasilitas;
use App\Models\User;
use App\Notifications\StatusPembayaranNotification;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = PembayaranFasilitas::with('peminjaman');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pembayaran = $query->orderBy('created_at', 'desc')->paginate(10);

        $statusList = ['menunggu', 'menunggu_verifikasi', 'berhasil', 'ditolak', 'dibatalkan'];

        return view('admin.pembayaran.index', compact('pembayaran', 'statusList'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'nullable|string|max:500'
        ]);

        $pembayaran = PembayaranFasilitas::findOrFail($id);

        // Generate QR Code menggunakan controller method
        $bayarController = new \App\Http\Controllers\BayarController();
        return $bayarController->approvePembayaran($request, $id);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:500'
        ]);

        $bayarController = new \App\Http\Controllers\BayarController();
        return $bayarController->rejectPembayaran($request, $id);
    }

    public function updateStatus(Request $request, $id)
    {
        $pembayaran = PembayaranFasilitas::findOrFail($id);
        $oldStatus = $pembayaran->status;

        $pembayaran->status = $request->status;
        $pembayaran->save();

        // Kirim notifikasi jika status berubah
        if ($oldStatus !== $request->status) {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new StatusPembayaranNotification($pembayaran, $request->status));
            }
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pembayaran = PembayaranFasilitas::findOrFail($id);
        $pembayaran->delete();

        return redirect()->route('pembayaran')->with('success', 'Pembayaran deleted successfully.');
    }

    public function print($id)
    {
        $pembayaran = PembayaranFasilitas::with('peminjaman')->findOrFail($id);

        $pdf = Pdf::loadView('admin.pembayaran.print', compact('pembayaran'))->setPaper('A4', 'portrait');
        return $pdf->stream('Pembayaran-' . $pembayaran->order_id . '.pdf');
    }
}
