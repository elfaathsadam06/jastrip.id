<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;
use FFMpeg\FFProbe;

class PemesananController extends Controller
{
    public function create()
    {
        return view('customer.pemesanan');
    }

    public function store(Request $request)
    {
        $request->validate([
            'audio' => 'required|file|mimes:mp3,wav,m4a|max:102400',
            'verification_transkriptor' => 'nullable',
        ]);

        // ===============================
        // SIMPAN AUDIO
        // ===============================
        $path = $request->file('audio')->store('audio', 'public');
        $fullPath = storage_path('app/public/' . $path);

        // ===============================
        // HITUNG DURASI
        // ===============================
        $ffprobe = FFProbe::create();
        $durationSeconds = $ffprobe->format($fullPath)->get('duration');
        $durasiMenit = ceil($durationSeconds / 60);

        // ===============================
        // HITUNG BIAYA
        // ===============================
        $total = $durasiMenit * 3000;
        $verification = $request->input('verification_transkriptor') == 1;

        if ($verification) {
            $total += $durasiMenit * 1000;
        }

        // ===============================
        // ORDER NUMBER PER USER (AMAN)
        // ===============================
        $lastOrderNumber = Pesanan::where('user_id', Auth::id())
            ->max('order_number');

        $orderNumber = $lastOrderNumber ? $lastOrderNumber + 1 : 1;

        // ===============================
        // SIMPAN PESANAN (SATU KALI SAJA)
        // ===============================
        $pesanan = Pesanan::create([
            'user_id' => Auth::id(),
            'order_number' => $orderNumber,
            'file_audio' => $path,
            'durasi' => $durasiMenit,
            'need_transkriptor_verification' => $verification,
            'total_biaya' => $total,
            'status' => 'waiting_payment',
        ]);

        return redirect()
            ->route('payment.pay', $pesanan->id)
            ->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
    }

    // ===============================
    // FORM PEMBAYARAN
    // ===============================
    public function paymentForm($id)
    {
        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($pesanan->status !== 'waiting_payment') {
            return redirect()->route('customer.dashboard')
                ->with('warning', 'Pesanan ini tidak dapat dibayar.');
        }

        return view('customer.pay', compact('pesanan'));
    }

    // ===============================
    // UPLOAD BUKTI PEMBAYARAN
    // ===============================
    public function uploadPayment(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:bca,mandiri,qris',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $path = $request->file('bukti_pembayaran')
            ->store('bukti-pembayaran', 'public');

        $pesanan->update([
            'payment_method' => $request->payment_method,
            'bukti_pembayaran' => $path,
            'status' => 'waiting_verification',
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }
}
