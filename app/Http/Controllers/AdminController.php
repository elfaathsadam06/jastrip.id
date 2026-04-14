<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pesanan;
use App\Models\Transkripsi;
use App\Models\RevisiTranskripsi;
use Illuminate\Http\Request;
use App\Services\GoogleSpeechService;

class AdminController extends Controller
{
    /* ================================
     * DASHBOARD
     * ================================ */
    public function index()
    {
        session(['admin_payment_back' => url()->current()]);

        return view('admin.dashboard', [
            'totalUsers' => User::where('role', 'customer')->count(),
            'totalPesanan' => Pesanan::count(),

            'waitingPayment'     => Pesanan::where('status', 'waiting_payment')->count(),
            'waitingVerification'=> Pesanan::where('status', 'waiting_verification')->count(),
            'processing'         => Pesanan::where('status', 'processing')->count(),
            'completed'          => Pesanan::where('status', 'completed')->count(),
            'rejected'           => Pesanan::where('status', 'rejected')->count(),
        ]);
    }

    /**
     * ================================
     * USER MANAGEMENT
     * ================================
     */
    public function users()
    {
        $users = User::where('role', 'customer')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::where('role', 'customer')->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::where('role', 'customer')->findOrFail($id);

        $request->validate([
            'name'   => 'required',
            'email'  => 'required|email|unique:users,email,' . $id,
            'status' => 'required|boolean',
        ]);

        $user->update($request->only('name', 'email', 'status'));

        return redirect()->route('admin.users')
            ->with('success', 'Data customer berhasil diperbarui');
    }

    public function deleteUser($id)
    {
        $user = User::where('role', 'customer')->findOrFail($id);

        if ($user->status == 1) {
            return back()->with('error', 'Nonaktifkan user terlebih dahulu');
        }

        $user->delete();

        return back()->with('success', 'Customer berhasil dihapus');
    }

    /* ================================
     * PESANAN
     * ================================ */
    public function pesananIndex()
    {
        $pesanan = Pesanan::with('user')->latest()->paginate(20);
        return view('admin.pesanan.index', compact('pesanan'));
    }

    public function pesananDetail($id)
    {
        $pesanan = Pesanan::with(['user','transkripsi'])->findOrFail($id);
        $transkriptors = User::where('role', 'transkriptor')
            ->withCount([
                'pesananTranskriptor as beban_kerja' => function ($q) {
                    $q->whereIn('status_transkriptor', ['waiting', 'processing']);
                }
            ])
            ->orderBy('beban_kerja', 'asc')
            ->get();

        return view('admin.pesanan.detail', compact('pesanan','transkriptors'));
    }

    /* ================================
     * PEMBAYARAN
     * ================================ */
    public function pembayaranIndex()
    {
        // SIMPAN halaman ini sebagai halaman kembali
        session(['admin_payment_back' => url()->current()]);

        $pesanan = Pesanan::with('user', 'pembayaran')
            ->where('status','waiting_verification')
            ->latest()
            ->paginate(20);

        return view('admin.pembayaran.index', compact('pesanan'));
    }

    public function pembayaranDetail($id)
    {
        $pesanan = Pesanan::with('user', 'pembayaran')->findOrFail($id);
        return view('admin.pembayaran.detail', compact('pesanan'));
    }

    /**
     * APPROVE PEMBAYARAN + AUTO AI
     */
    public function approvePayment($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status !== 'waiting_verification') {
            return back()->with('error', 'Status tidak valid');
        }

        // UPDATE STATUS PEMBAYARAN
        $pesanan->update([
            'status' => 'processing',
            'verified_by_admin_id' => auth()->id(),
            'admin_action' => 'approved',
            'verified_at' => now(),
        ]);

        // 🔥 BUAT DATA TRANSKRIPSI (JIKA BELUM ADA)
        $transkripsi = Transkripsi::firstOrCreate(
            ['pesanan_id' => $pesanan->id],
            ['status' => 'processing']
        );

        try {
            // 🔥 JALANKAN AI
            $hasil = GoogleSpeechService::transcribe($pesanan->file_audio);

            // SIMPAN HASIL
            $transkripsi->update([
                'hasil' => $hasil,
                'status' => 'done',
            ]);

            // UPDATE PESANAN
            $pesanan->update([
                'status' => 'completed',
            ]);

            return back()->with('success', 'Pembayaran disetujui & AI selesai');

        } catch (\Exception $e) {

            $transkripsi->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            return back()->with('error', 'AI gagal diproses');
        }
    }

    public function rejectPayment($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $pesanan->update([
            'status' => 'rejected',
            'verified_by_admin_id' => auth()->id(),
            'admin_action' => 'rejected',
            'verified_at' => now(),
        ]);

        return back()->with('warning','Pembayaran ditolak');
    }

    /**
     * MANUAL PROSES AI
     */
    public function prosesTranskripsi($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status !== 'processing') {
            return back()->with('error','Pesanan belum diproses');
        }

        $transkripsi = Transkripsi::firstOrCreate(
            ['pesanan_id'=>$pesanan->id],
            ['status'=>'processing']
        );

        try {
            $pesanan->update([
                'status'=>'processing',
            ]);

            $hasil = GoogleSpeechService::transcribe($pesanan->file_audio);

            $transkripsi->update([
                'hasil'=>$hasil,
                'status'=>'done'
            ]);

            $pesanan->update([
                'status'=>'completed',
            ]);

            return back()->with('success','AI selesai');

        } catch (\Exception $e) {

            $transkripsi->update([
                'status'=>'failed',
                'error_message'=>$e->getMessage()
            ]);

            return back()->with('error','AI gagal');
        }
    }

    /* ================================
     * TRANSKRIPTOR
     * ================================ */
    public function kirimKeTranskriptor(Request $request, $id)
    {
        $request->validate([
            'assigned_transkriptor_id' => 'required|exists:users,id',
        ]);

        $pesanan = Pesanan::with('transkripsi')->findOrFail($id);

        if (!$pesanan->need_transkriptor_verification) {
            abort(403, 'Pesanan ini tidak membutuhkan verifikasi');
        }

        // Assign transkriptor
        $pesanan->update([
            'assigned_transkriptor_id' => $request->assigned_transkriptor_id,
            'status_transkriptor' => 'waiting',
        ]);

        // Buat entry revisi (TASK)
        RevisiTranskripsi::create([
            'pesanan_id'     => $pesanan->id,
            'transkripsi_id' => $pesanan->transkripsi->id,
            'transkriptor_id'=> $request->assigned_transkriptor_id,
            'hasil_revisi'   => '', // ⬅️ WAJIB ADA
            'catatan'        => 'Silakan verifikasi hasil transkripsi AI',
        ]);

        return back()->with('success', 'Tugas berhasil dikirim ke transkriptor');
    }
}
