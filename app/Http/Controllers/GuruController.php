<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;

class GuruController extends Controller
{
    // Halaman Login Guru
    public function loginPage()
    {
        // Jika sudah login sebagai guru, langsung ke dashboard
        if (session('guru_id')) {
            return redirect()->route('dashboard.guru');
        }
        return view('guru.login');
    }

    // Proses Login Guru
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari guru berdasarkan username
        $guru = Guru::where('username', $request->username)->first();

        // Cek password (plain text sesuai permintaan)
        if (!$guru || $guru->password !== $request->password) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Username atau password salah!');
        }

        // Simpan session guru
        session([
            'guru_id'         => $guru->id,
            'guru_nama'       => $guru->nama,
            'guru_no_telepon' => $guru->no_telepon ?? '0819-5249-9521',
        ]);

        return redirect()->route('dashboard.guru');
    }

    // Dashboard Guru BK — hanya bisa diakses setelah login
    public function dashboard()
    {
        if (!session('guru_id')) {
            return redirect()->route('guru.loginPage')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $siswaList = Siswa::latest()->get();
        return view('guru.dashboard', compact('siswaList'));
    }

    // Logout Guru
    public function logout()
    {
        session()->forget(['guru_id', 'guru_nama', 'guru_no_telepon']);
        return redirect()->route('guru.loginPage')
            ->with('success', 'Anda berhasil logout.');
    }
}
