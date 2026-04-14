<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Transkripsi;
use App\Services\GoogleSpeechService;

class GoogleSpeechController extends Controller
{
    public function process($id)
    {
        $pesanan = Pesanan::with('transkripsi')->findOrFail($id);

        if ($pesanan->status !== 'paid') {
            return back()->with('error', 'Pesanan harus dibayar terlebih dahulu.');
        }

        try {
            // update status pesanan
            $pesanan->update([
                'status' => 'processing',
            ]);

            // buat / update transkripsi
            $transkripsi = Transkripsi::updateOrCreate(
                ['pesanan_id' => $pesanan->id],
                ['status' => 'processing']
            );

            // proses google speech
            $text = GoogleSpeechService::transcribe($pesanan->file_audio);

            // simpan hasil
            $transkripsi->update([
                'hasil' => $text,
                'status' => 'done',
                'error_message' => null,
            ]);

            $pesanan->update([
                'status' => 'completed',
            ]);

            return back()->with('success', 'Transkripsi AI berhasil.');

        } catch (\Throwable $e) {

            Transkripsi::updateOrCreate(
                ['pesanan_id' => $pesanan->id],
                [
                    'status' => 'failed',
                    'error_message' => $e->getMessage()
                ]
            );

            $pesanan->update([
                'status' => 'paid'
            ]);

            return back()->with('error', 'Google Speech Error.');
        }
    }
}
