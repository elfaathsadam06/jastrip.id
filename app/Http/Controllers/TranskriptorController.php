<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\RevisiTranskripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class TranskriptorController extends Controller
{
    /* =========================
     * DASHBOARD
     * ========================= */
    public function dashboard()
    {
        $userId = Auth::id();

        return view('transkriptor.dashboard', [
            'pending' => Pesanan::where('assigned_transkriptor_id', $userId)
                ->where('status_transkriptor', 'waiting')
                ->count(),

            'working' => Pesanan::where('assigned_transkriptor_id', $userId)
                ->where('status_transkriptor', 'working')
                ->count(),

            'submitted' => Pesanan::where('assigned_transkriptor_id', $userId)
                ->where('status_transkriptor', 'submitted')
                ->count(),
        ]);
    }

    /* =========================
     * LIST TUGAS
     * ========================= */
    public function tasks()
    {
        $tasks = Pesanan::where('assigned_transkriptor_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transkriptor.tasks', compact('tasks'));
    }

    /* =========================
     * DETAIL TUGAS
     * ========================= */
    public function show($id)
    {
        $task = Pesanan::with('transkripsi')
            ->where('assigned_transkriptor_id', Auth::id())
            ->findOrFail($id);

        return view('transkriptor.task-show', compact('task'));
    }

    /* =========================
     * DOWNLOAD WORD AI
     * ========================= */
    public function downloadWord(Pesanan $pesanan)
    {
        abort_if($pesanan->assigned_transkriptor_id !== Auth::id(), 403);
        abort_if(!$pesanan->transkripsi, 404, 'Hasil AI belum tersedia');

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText($pesanan->transkripsi->hasil, ['size' => 11]);

        $fileName = "hasil-ai-pesanan-{$pesanan->id}.docx";
        $path = storage_path("app/public/{$fileName}");

        IOFactory::createWriter($phpWord, 'Word2007')->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    /* =========================
     * DOWNLOAD AUDIO
     * ========================= */
    public function downloadAudio(Pesanan $pesanan)
    {
        abort_if($pesanan->assigned_transkriptor_id !== Auth::id(), 403);

        return Storage::disk('public')->download($pesanan->file_audio);
    }

    /* =========================
     * FORM KERJAKAN TUGAS
     * ========================= */
    public function edit(Pesanan $pesanan)
    {
        abort_if($pesanan->assigned_transkriptor_id !== Auth::id(), 403);

        // 🔁 otomatis jadi working saat mulai
        if ($pesanan->status_transkriptor === 'waiting') {
            $pesanan->update([
                'status_transkriptor' => 'working'
            ]);
        }

        return view('transkriptor.task-edit', compact('pesanan'));
    }

    /* =========================
     * SIMPAN / KIRIM KE CUSTOMER
     * ========================= */
    public function update(Request $request, Pesanan $pesanan)
    {
        abort_if($pesanan->assigned_transkriptor_id !== auth()->id(), 403);

        $request->validate([
            'hasil_transkriptor' => 'required|string'
        ]);

        $transkripsi = $pesanan->transkripsi;
        abort_if(!$transkripsi, 400, 'Transkripsi AI belum tersedia');

        // ================================
        // AMBIL DRAFT TERAKHIR (JIKA ADA)
        // ================================
        $revisi = RevisiTranskripsi::where('pesanan_id', $pesanan->id)
            ->where('transkriptor_id', auth()->id())
            ->latest()
            ->first();

        if ($revisi) {
            // update draft lama
            $revisi->update([
                'hasil_revisi' => $request->hasil_transkriptor,
                'catatan' => $request->submit == 1
                    ? 'Dikirim ke customer'
                    : 'Draft disimpan',
            ]);
        } else {
            // buat draft baru
            $revisi = RevisiTranskripsi::create([
                'pesanan_id'     => $pesanan->id,
                'transkripsi_id' => $transkripsi->id,
                'transkriptor_id'=> auth()->id(),
                'hasil_revisi'   => $request->hasil_transkriptor,
                'catatan'        => $request->submit == 1
                    ? 'Dikirim ke customer'
                    : 'Draft disimpan',
            ]);
        }

        // ================================
        // SIMPAN SAJA (DRAFT)
        // ================================
        if ($request->submit == 0) {
            $pesanan->update([
                'status_transkriptor' => 'working'
            ]);

            return redirect()
                ->route('transkriptor.tasks.show', $pesanan->id)
                ->with('success', 'Draft berhasil disimpan');
        }

        // ================================
        // KIRIM KE CUSTOMER
        // ================================
        $pesanan->update([
            'status_transkriptor' => 'submitted',
            'status'              => 'completed',
        ]);

        $transkripsi->update([
            'status' => 'done',
        ]);

        return redirect()
            ->route('transkriptor.tasks.index')
            ->with('success', 'Tugas berhasil dikirim ke customer');
    }
}
