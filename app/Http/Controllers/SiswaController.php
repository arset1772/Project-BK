<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class SiswaController extends Controller
{
    // Halaman Login Siswa
    public function loginPage()
    {
        // Jika sudah login, langsung ke dashboard siswa
        if (session('siswa_id')) {
            return redirect()->route('siswa.dashboard');
        }
        return view('siswa.login');
    }

    // Proses Login / Registrasi Siswa
    public function login(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|digits_between:1,20',
        ]);

        $siswa = Siswa::firstOrCreate(
            ['nisn' => $request->nisn],
            ['nama' => $request->nama, 'kelas' => '-', 'status' => 'Belum Asesmen']
        );

        // Jika NISN sudah ada, update nama jika berbeda
        if (!$siswa->wasRecentlyCreated && $siswa->nama !== $request->nama) {
            // Tetap gunakan data yang sudah ada, tidak perlu update nama
        }

        session(['siswa_id' => $siswa->id]);
        return redirect()->route('siswa.dashboard');
    }

    // Tampilkan Dashboard Siswa (halaman asesmen)
    public function dashboard()
    {
        $siswaId = session('siswa_id');
        if (!$siswaId) {
            return redirect()->route('siswa.loginPage')->with('error', 'Silakan login terlebih dahulu.');
        }

        $currentSiswa = Siswa::find($siswaId);
        if (!$currentSiswa) {
            session()->forget('siswa_id');
            return redirect()->route('siswa.loginPage')->with('error', 'Sesi tidak valid, silakan login ulang.');
        }

        return view('siswa.dashboard', compact('currentSiswa'));
    }

    // Simpan hasil 10 pertanyaan asesmen
    public function submitAssessment(Request $request)
    {
        $siswaId = session('siswa_id');
        if (!$siswaId) {
            return redirect()->route('siswa.loginPage')->with('error', 'Sesi habis, silakan login ulang.');
        }

        $request->validate([
            'kelas'        => 'required|string',
            'pilihan_akhir'=> 'required|string',
        ]);

        $kelas = $request->kelas;

        // Hitung skor dari 10 pertanyaan (q1 sampai q10)
        $scores = ['sains' => 0, 'sosial' => 0, 'seni' => 0];
        for ($i = 1; $i <= 10; $i++) {
            $answer = $request->input("q{$i}");
            if (isset($scores[$answer])) {
                $scores[$answer]++;
            }
        }

        // Tentukan Kluster Dominan
        $kluster = 'Sains & Teknologi';
        if ($scores['sosial'] >= $scores['sains'] && $scores['sosial'] >= $scores['seni']) {
            $kluster = 'Sosial & Bisnis';
        } elseif ($scores['seni'] >= $scores['sains'] && $scores['seni'] >= $scores['sosial']) {
            $kluster = 'Seni & Kreatif';
        }

        $pilihanTerkunci = $request->pilihan_akhir;

        // Update database
        $siswa = Siswa::find($siswaId);
        if (!$siswa) {
            return redirect()->route('siswa.loginPage')->with('error', 'Data siswa tidak ditemukan.');
        }

        $siswa->update([
            'kelas'            => $kelas,
            'kluster'          => $kluster,
            'pilihan_terkunci' => $pilihanTerkunci,
            'status'           => 'Terverifikasi'
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Asesmen berhasil disimpan ke database!');
    }

    // Reset asesmen siswa (ulangi)
    public function resetAssessment()
    {
        $siswaId = session('siswa_id');
        if ($siswaId) {
            $siswa = Siswa::find($siswaId);
            if ($siswa) {
                $siswa->update([
                    'kelas'            => '-',
                    'kluster'          => null,
                    'pilihan_terkunci'  => null,
                    'status'           => 'Belum Asesmen',
                ]);
            }
        }
        return redirect()->route('siswa.dashboard');
    }

    // Logout siswa
    public function logout()
    {
        session()->forget('siswa_id');
        return redirect()->route('siswa.loginPage');
    }

    // Dashboard Guru BK
    public function dashboardGuru()
    {
        $siswaList = Siswa::latest()->get();
        return view('guru.dashboard', compact('siswaList'));
    }
}