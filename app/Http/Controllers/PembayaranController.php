<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    /**
     * FORM PEMBAYARAN
     */
    public function pay($id)
    {
        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($pesanan->status !== 'waiting_payment') {
            return redirect()->route('customer.dashboard');
        }

        // 🔥 BELUM ADA PEMBAYARAN
        $pembayaran = null;

        return view('customer.pay', compact('pesanan', 'pembayaran'));
    }

    /**
     * UPLOAD BUKTI PEMBAYARAN
     */
    public function uploadPayment(Request $request, $id)
    {
        $request->validate([
            'payment_method'   => 'required|in:bca,mandiri,qris',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // proteksi double submit
        if ($pesanan->status !== 'waiting_payment') {
            return redirect()->route('customer.dashboard');
        }

        DB::transaction(function () use ($request, $pesanan) {

            /* ===============================
             * SIMPAN FILE BUKTI
             * =============================== */
            $path = $request->file('bukti_pembayaran')
                ->store('bukti-pembayaran', 'public');

            /* ===============================
             * SIMPAN KE TABEL PEMBAYARAN
             * =============================== */
            Pembayaran::create([
                'pesanan_id' => $pesanan->id,
                'method'     => $request->payment_method,
                'bukti'      => $path,
                'amount'     => $pesanan->total_biaya,
                'status'     => 'pending',
                'paid_at'    => now(),
            ]);

            /* ===============================
             * UPDATE STATUS PESANAN SAJA
             * =============================== */
            $pesanan->update([
                'status' => 'waiting_verification',
            ]);
        });

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }
}
