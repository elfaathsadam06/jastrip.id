<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class CustomerController extends Controller
{
    /**
     * Dashboard Customer
     */
    public function dashboard()
    {
        $pesanan = Pesanan::with('transkripsi')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.dashboard', compact('pesanan'));
    }

    /**
     * Daftar pesanan
     */
    public function orders()
    {
        $pesanan = Pesanan::with('transkripsi')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.orders', compact('pesanan'));
    }

    /**
     * Lihat hasil transkripsi
     */
    public function showTranscript($id)
    {
        $pesanan = Pesanan::with(['transkripsi.revisiTerakhir'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        abort_if(
            !$pesanan->transkripsi || $pesanan->speech_status !== 'done',
            403,
            'Transkripsi belum tersedia'
        );

        return view('customer.transcript', compact('pesanan'));
    }

    /**
     * Download Word
     */
    public function downloadWord($id)
    {
        $pesanan = Pesanan::with('transkripsi')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addText($pesanan->transkripsi->hasil);

        $fileName = "transkripsi-pesanan-{$pesanan->id}.docx";
        $path = storage_path("app/public/$fileName");

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    /**
     * Download PDF
     */
    public function downloadPdf($id)
    {
        $pesanan = Pesanan::with('transkripsi')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $pdf = Pdf::loadView('customer.transcript_pdf', [
            'pesanan' => $pesanan
        ]);

        return $pdf->download("transkripsi-pesanan-{$pesanan->id}.pdf");
    }

    public function detailVerifikasi($pesananId)
    {
        $pesanan = Pesanan::with('transkripsi.revisiTerakhir')
            ->where('id', $pesananId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        abort_unless($pesanan->need_transkriptor_verification, 403);

        return view('customer.transkripsi-verifikasi', compact('pesanan'));
    }

}
