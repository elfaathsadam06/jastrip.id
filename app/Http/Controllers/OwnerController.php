<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller
{
    // ================= DASHBOARD =================
public function dashboard()
{
    return view('owner.dashboard', [
        'totalPesanan' => Pesanan::count(),

        'transaksiSukses' => Pesanan::whereIn('status', [
            'paid','completed'
        ])->count(),

        'pelangganAktif' => User::where('role', 'customer')->count(),
        'totalAdmin' => User::where('role', 'admin')->count(),
        'totalTranskriptor' => User::where('role', 'transkriptor')->count(),

        // CHART
        'chartCompleted' => Pesanan::where('status','completed')->count(),
        'chartProcessing' => Pesanan::whereIn('status', [
            'processing','processing_transkriptor'
        ])->count(),
        'chartWaiting' => Pesanan::where('status','waiting_verification')->count(),
    ]);
}

    // ================= ADMIN =================
    public function admins()
    {
        return view('owner.admins', [
            'admins' => User::where('role', 'admin')->get()
        ]);
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'status'   => 1,
        ]);

        return back()->with('success', 'Admin berhasil dibuat. Password default: admin123');
    }

    public function editAdmin($id)
    {
        $admin = User::where('role','admin')->findOrFail($id);
        return view('owner.admins-edit', compact('admin'));
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = User::where('role','admin')->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $admin->password,
        ]);

        return redirect()->route('owner.admins')->with('success','Data Admin Diperbarui');
    }

    public function resetAdminPassword($id)
    {
        User::where('role','admin')->findOrFail($id)
            ->update(['password' => Hash::make('admin123')]);

        return back()->with('success','Password admin direset');
    }

    public function deleteAdmin($id)
    {
        User::where('role','admin')->findOrFail($id)->delete();
        return back()->with('success','Admin dihapus');
    }

    // ================= TRANSKRIPTOR =================
    public function transkriptors()
    {
        $transkriptors = User::where('role', 'transkriptor')->get();
        return view('owner.transkriptors', compact('transkriptors'));
    }

    public function storeTranskriptor(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'transkriptor',
            'password' => Hash::make('transkriptor123'),
            'status' => 1,
        ]);

        return back()->with('success', 'transkriptor berhasil dibuat. Password default: transkriptor123');
    }

    public function editTranskriptor($id)
    {
        $transkriptor = User::where('role','transkriptor')->findOrFail($id);
        return view('owner.transkriptors-edit', compact('transkriptor'));
    }

    public function updateTranskriptor(Request $request, $id)
    {
        $transkriptor = User::where('role','transkriptor')->findOrFail($id);

        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6'
        ]);

        $data = $request->only('name','email');

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $transkriptor->update($data);

        return redirect()
            ->route('owner.transkriptors')
            ->with('success','Data Transkriptor Diperbarui');
    }

    public function deleteTranskriptor($id)
    {
        User::where('role','transkriptor')->findOrFail($id)->delete();
        return back()->with('success', 'Transkriptor dihapus');
    }

    // ================= REPORT =================
    public function reports()
    {
        $totalPesanan = Pesanan::count();

        $pesananSelesai = Pesanan::where('status','completed')->count();

        $pesananDiproses = Pesanan::whereIn('status', [
            'processing',
            'waiting_verification'
        ])->count();

        $pesananDitolak = Pesanan::where('status','rejected')->count();

        $totalOmzet = Pesanan::where('status','completed')
            ->sum('total_biaya');

        $chartStatus = [
            'completed' => $pesananSelesai,
            'processing' => $pesananDiproses,
            'rejected' => $pesananDitolak,
        ];

        // 🔥 INI INTI KINERJA ADMIN
        $laporanAdmin = User::where('role','admin')
            ->withCount([
                'pesananDiverifikasi as pesanan_count' => function ($q) {
                    $q->whereIn('admin_action', ['approved','rejected']);
                }
            ])
            ->get();

        $laporanTranskriptor = User::where('role','transkriptor')
            ->withCount([
                'pesananTranskriptor as pesanan_count' => function ($q) {
                    $q->where('status_transkriptor', 'submitted');
                }
            ])
            ->get();

        return view('owner.reports', compact(
            'totalPesanan',
            'pesananSelesai',
            'pesananDiproses',
            'pesananDitolak',
            'totalOmzet',
            'chartStatus',
            'laporanAdmin',
            'laporanTranskriptor'
        ));
    }

    // ================= SETTINGS OWNER =================
    public function settings()
    {
        return view('owner.settings', [
            'owner' => Auth::user()
        ]);
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:6|confirmed'
        ], [
            'password.confirmed' => 'Password dan konfirmasi password tidak sesuai'
        ]);

        $owner = Auth::user();
        $owner->name = $request->name;
        $owner->email = $request->email;

        if ($request->filled('password')) {
            $owner->password = Hash::make($request->password);
        }

        $owner->save();

        return back()->with('success','Owner berhasil diperbarui');
    }
}
