<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerTranskripsiController extends Controller
{
    public function detail(Pesanan $pesanan)
    {
        abort_if($pesanan->user_id !== Auth::id(), 403);

        abort_if(
            !$pesanan->need_transkriptor_verification ||
            !$pesanan->transkripsi ||
            !$pesanan->transkripsi->revisiTerakhir,
            404
        );

        return view('customer.transkripsi-detail', [
            'pesanan' => $pesanan,
            'revisi'  => $pesanan->transkripsi->revisiTerakhir
        ]);
    }

    public function downloadWord(Pesanan $pesanan)
    {
        abort_if($pesanan->user_id !== Auth::id(), 403);

        $text = $pesanan->transkripsi->hasil;

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addText($text);

        $file = storage_path("app/transkripsi-{$pesanan->id}.docx");
        IOFactory::createWriter($phpWord, 'Word2007')->save($file);

        return response()->download($file)->deleteFileAfterSend(true);
    }

    public function downloadPdf(Pesanan $pesanan)
    {
        abort_if($pesanan->user_id !== Auth::id(), 403);

        $pdf = Pdf::loadView('customer.transkripsi-pdf', [
            'pesanan' => $pesanan
        ]);

        return $pdf->download("transkripsi-{$pesanan->id}.pdf");
    }
}
