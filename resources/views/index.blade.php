<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

  <title>QR-CAP | Sistem Bimbingan Konseling & Penempatan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { brand: { 500: '#10b981', 600: '#059669', 700: '#047857' } }
        }
      }
    }
  </script>
  <style> @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap'); body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col justify-between">

  @php
    $currentSiswaId = session('siswa_id');
    $currentSiswa = $currentSiswaId ? \App\Models\Siswa::find($currentSiswaId) : null;
  @endphp

  <!-- NAVBAR -->
  <header class="bg-white/90 backdrop-blur border-b border-slate-200 sticky top-0 z-40">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xl shadow">
          <i class="fa-solid fa-qrcode"></i>
        </div>
        <div>
          <h1 class="text-base font-extrabold text-slate-800">QR-CAP <span class="text-emerald-600">Database System</span></h1>
          <p class="text-[11px] text-slate-500">Portal BK & Penempatan Siswa</p>
        </div>
      </div>

      <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200">
        <button id="btn-mode-student" onclick="switchMode('student')" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-white text-emerald-600 shadow-sm">
          <i class="fa-solid fa-user-graduate mr-1"></i> Portal Siswa
        </button>
        <button id="btn-mode-teacher" onclick="switchMode('teacher')" class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-500 hover:text-emerald-600">
          <i class="fa-solid fa-chart-pie mr-1"></i> Dashboard Guru BK
        </button>
      </div>
    </div>
  </header>

  <!-- MAIN CONTAINER -->
  <main class="flex-grow flex items-center justify-center p-3 sm:p-6">

    <!-- PORTAL SISWA -->
    <div id="view-student" class="w-full max-w-lg bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-200">
      <div class="bg-gradient-to-br from-emerald-600 to-teal-800 text-white p-6">
        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white/20 text-emerald-100 mb-2">
          <i class="fa-solid fa-database text-yellow-300 mr-1"></i> Terhubung ke MySQL Database
        </span>
        <h2 class="text-xl font-bold">Layanan Asesmen & Penempatan</h2>
        <p class="text-xs text-emerald-100 mt-1">Isi 10 pertanyaan asesmen minat bakat secara akurat.</p>
      </div>

      <div class="p-5 sm:p-6 max-h-[75vh] overflow-y-auto">
        
        @if(!$currentSiswa)
          <!-- FORM LOGIN -->
          <form action="{{ route('siswa.login') }}" method="POST" class="space-y-3.5">
            @csrf
            <div class="text-center mb-3">
              <h3 class="text-base font-bold text-slate-800">Login / Registrasi Siswa</h3>
              <p class="text-xs text-slate-500">Masukkan Nama dan NISN Anda untuk mulai.</p>
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap</label>
              <input type="text" name="nama" required placeholder="Contoh: Budi Santoso" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1">Kelas (Opsional)</label>
              <input type="text" name="kelas" placeholder="Contoh: X-1, XI IPA 1, XII IPS 2" value="{{ old('kelas') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1">NISN</label>
              <input type="number" name="nisn" required placeholder="10 Digit NISN" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
            </div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl text-xs shadow-lg">
              Masuk / Mulai Asesmen <i class="fa-solid fa-arrow-right ml-1"></i>
            </button>
          </form>

        @else
          <!-- DASHBOARD SISWA -->
          <div class="space-y-4">
            <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-2xl flex items-center justify-between">
              <div>
                <span class="text-[10px] font-bold text-emerald-600 uppercase">Siswa Terautentikasi:</span>
                <h3 class="text-sm font-extrabold text-slate-800">{{ $currentSiswa->nama }}</h3>
                <p class="text-xs text-slate-500">NISN: {{ $currentSiswa->nisn }} | Kelas: {{ $currentSiswa->kelas }}</p>
              </div>
              <a href="{{ route('siswa.logout') }}" class="text-xs text-rose-600 font-semibold hover:underline">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar
              </a>
            </div>

            @if($currentSiswa->status == 'Terverifikasi')
              <div class="bg-slate-900 text-slate-100 p-4 rounded-2xl text-xs space-y-2">
                <span class="text-emerald-400 font-bold"><i class="fa-solid fa-circle-check"></i> Asesmen Telah Disimpan di Database</span>
                <p class="text-slate-400">Kluster Dominan: <strong class="text-white">{{ $currentSiswa->kluster }}</strong></p>
                <p class="text-slate-400">Pilihan Terkunci: <strong class="text-amber-300">{{ $currentSiswa->pilihan_terkunci }}</strong></p>
              </div>
              <!-- Kontak Konsul Guru BK -->
              <div class="bg-blue-50 border border-blue-200 p-3.5 rounded-2xl text-xs flex items-center justify-between">
                <div>
                  <p class="text-[10px] font-bold text-blue-600 uppercase">Kontak Konsul Guru BK</p>
                  <p class="font-extrabold text-slate-800">{{ $guruKonsul['nama'] }}</p>
                  <p class="text-slate-600 font-semibold">{{ $guruKonsul['telepon'] }}</p>
                </div>
                <a href="https://wa.me/{{ $guruKonsul['wa_number'] }}" target="_blank" class="bg-emerald-600 text-white px-3 py-1.5 rounded-xl font-bold flex items-center gap-1">
                  <i class="fa-brands fa-whatsapp"></i> Konsul
                </a>
              </div>
              <button onclick="location.reload()" class="w-full bg-slate-200 text-slate-700 font-bold py-2.5 rounded-xl text-xs">Ulangi Asesmen</button>
            @else
              <!-- 10 PERTANYAAN ASESMEN -->
              <form action="{{ route('siswa.assessment') }}" method="POST" class="space-y-4">
                @csrf
                <div class="border-b pb-2">
                  <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Form Asesmen (10 Pertanyaan)</span>
                </div>

                <div>
                  <label class="block text-xs font-semibold text-slate-600 mb-1">Kelas Anda</label>
                  <input type="text" name="kelas" required placeholder="Masukkan Kelas Anda (Contoh: X-1, XI IPA 1)" value="{{ old('kelas', ($currentSiswa && $currentSiswa->kelas !== '-') ? $currentSiswa->kelas : '') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-600">
                </div>

                <!-- Pertanyaan 1 -->
                <div class="bg-slate-50 p-3 rounded-xl border">
                  <p class="text-xs font-bold mb-2">1. Aktivitas apa yang paling memicu minat Anda?</p>
                  <label class="block text-xs mb-1"><input type="radio" name="q1" value="sains" required> Analisis logika, coding, atau eksperimen sains</label>
                  <label class="block text-xs mb-1"><input type="radio" name="q1" value="sosial"> Diskusi, negosiasi, kepemimpinan & organisasi</label>
                  <label class="block text-xs"><input type="radio" name="q1" value="seni"> Menggambar, desain visual, atau seni musik</label>
                </div>

                <!-- Pertanyaan 2 -->
                <div class="bg-slate-50 p-3 rounded-xl border">
                  <p class="text-xs font-bold mb-2">2. Mata pelajaran mana yang paling konsisten nilai tinggi?</p>
                  <label class="block text-xs mb-1"><input type="radio" name="q2" value="sains" required> Matematika, Fisika, Biologi, Informatika</label>
                  <label class="block text-xs mb-1"><input type="radio" name="q2" value="sosial"> Ekonomi, Sosiologi, Geografi, Sejarah</label>
                  <label class="block text-xs"><input type="radio" name="q2" value="seni"> Seni Budaya, Prakarya, Bahasa</label>
                </div>

                <!-- Pertanyaan 3 -->
                <div class="bg-slate-50 p-3 rounded-xl border">
                  <p class="text-xs font-bold mb-2">3. Bagaimana gaya belajar ideal Anda?</p>
                  <label class="block text-xs mb-1"><input type="radio" name="q3" value="sains" required> Sistematis, berbasis data & pembuktian</label>
                  <label class="block text-xs mb-1"><input type="radio" name="q3" value="sosial"> Diskusi kelompok aktif & interaksi sosial</label>
                  <label class="block text-xs"><input type="radio" name="q3" value="seni"> Eksploratif, fleksibel, mengutamakan estetika</label>
                </div>

                <!-- Pertanyaan 4 -->
                <div class="bg-slate-50 p-3 rounded-xl border">
                  <p class="text-xs font-bold mb-2">4. Proyek impian seperti apa yang ingin Anda buat?</p>
                  <label class="block text-xs mb-1"><input type="radio" name="q4" value="sains" required> Aplikasi software atau robot otomatis</label>
                  <label class="block text-xs mb-1"><input type="radio" name="q4" value="sosial"> Kampanye sosial atau rintisan bisnis startup</label>
                  <label class="block text-xs"><input type="radio" name="q4" value="seni"> Pameran seni, film pendek, atau desain brand</label>
                </div>

                <!-- Pertanyaan 5 -->
                <div class="bg-slate-50 p-3 rounded-xl border">
                  <p class="text-xs font-bold mb-2">5. Buku atau topik bacaan apa yang sering Anda pilih?</p>
                  <label class="block text-xs mb-1"><input type="radio" name="q5" value="sains" required> Teknologi masa depan, sains antariksa, algoritma</label>
                  <label class="block text-xs mb-1"><input type="radio" name="q5" value="sosial"> Psikologi manusia, ekonomi makro, biografi tokoh</label>
                  <label class="block text-xs"><input type="radio" name="q5" value="seni"> Fotografi, desain arsitektur, sejarah seni</label>
                </div>

                <!-- Pertanyaan 6 -->
                <div class="bg-slate-50 p-3 rounded-xl border">
                  <p class="text-xs font-bold mb-2">6. Ketika menghadapi masalah rumit, apa tindakan pertama Anda?</p>
                  <label class="block text-xs mb-1"><input type="radio" name="q6" value="sains" required> Mencari pola data dan menguji hipotesis</label>
                  <label class="block text-xs mb-1"><input type="radio" name="q6" value="sosial"> Mengajak orang lain berdiskusi dan mencari konsensus</label>
                  <label class="block text-xs"><input type="radio" name="q6" value="seni"> Mencari sudut pandang unik dan pendekatan kreatif</label>
                </div>

                <!-- Pertanyaan 7 -->
                <div class="bg-slate-50 p-3 rounded-xl border">
                  <p class="text-xs font-bold mb-2">7. Ekstrakurikuler mana yang paling menarik bagi Anda?</p>
                  <label class="block text-xs mb-1"><input type="radio" name="q7" value="sains" required> Karya Ilmiah Remaja / Klub Robotik</label>
                  <label class="block text-xs mb-1"><input type="radio" name="q7" value="sosial"> Debat Bahasa Inggris / OSIS / PMR</label>
                  <label class="block text-xs"><input type="radio" name="q7" value="seni"> Teater, Desain Grafis, atau Paduan Suara</label>
                </div>

                <!-- Pertanyaan 8 -->
                <div class="bg-slate-50 p-3 rounded-xl border">
                  <p class="text-xs font-bold mb-2">8. Suasana kerja seperti apa yang Anda sukai di masa depan?</p>
                  <label class="block text-xs mb-1"><input type="radio" name="q8" value="sains" required> Laboratorium riset atau kantor tech company</label>
                  <label class="block text-xs mb-1"><input type="radio" name="q8" value="sosial"> Ruang rapat korporat, lembaga sosial, atau instansi</label>
                  <label class="block text-xs"><input type="radio" name="q8" value="seni"> Studio kreatif yang bebas dan penuh warna</label>
                </div>

                <!-- Pertanyaan 9 -->
                <div class="bg-slate-50 p-3 rounded-xl border">
                  <p class="text-xs font-bold mb-2">9. Media sosial atau platform apa yang paling sering Anda pelajari?</p>
                  <label class="block text-xs mb-1"><input type="radio" name="q9" value="sains" required> GitHub, StackOverflow, kanal sains/teknik</label>
                  <label class="block text-xs mb-1"><input type="radio" name="q9" value="sosial"> LinkedIn, portal berita bisnis & ekonomi</label>
                  <label class="block text-xs"><input type="radio" name="q9" value="seni"> Behance, Instagram Art, Pinterest, YouTube creator</label>
                </div>

                <!-- Pertanyaan 10 -->
                <div class="bg-slate-50 p-3 rounded-xl border">
                  <p class="text-xs font-bold mb-2">10. Target profesi masa depan yang paling mendekati impian Anda?</p>
                  <label class="block text-xs mb-1"><input type="radio" name="q10" value="sains" required> Software Engineer / Dokter / Peneliti</label>
                  <label class="block text-xs mb-1"><input type="radio" name="q10" value="sosial"> Psikolog / Diplomat / Entrepreneur / Manajer</label>
                  <label class="block text-xs"><input type="radio" name="q10" value="seni"> Creative Director / Animator / Desainer / Penulis</label>
                </div>

                <!-- Pilihan Rekomendasi Akhir -->
                <div>
                  <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Rekomendasi Penempatan Final:</label>
                  <select name="pilihan_akhir" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs bg-white">
                    <option value="Teknik Informatika & Robotik">Teknik Informatika & Robotik</option>
                    <option value="Psikologi & Manajemen Bisnis">Psikologi & Manajemen Bisnis</option>
                    <option value="Desain Komunikasi Visual (DKV) & Seni">Desain Komunikasi Visual (DKV) & Seni</option>
                  </select>
                </div>

                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl text-xs shadow">
                  Simpan ke Database MySQL <i class="fa-solid fa-cloud-arrow-up ml-1"></i>
                </button>
              </form>
            @endif
          </div>
        @endif

      </div>
    </div>

    <!-- DASHBOARD GURU BK -->
    <div id="view-teacher" class="hidden w-full max-w-5xl space-y-4">
      <div class="bg-white p-5 rounded-3xl border border-slate-200 flex justify-between items-center">
        <div>
          <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 inline-block mb-1">
            <i class="fa-solid fa-user-shield"></i> Dashboard Guru BK (Database MySQL)
          </span>
          <h2 class="text-xl font-bold text-slate-800">Rekapitulasi Data Siswa</h2>
        </div>
      </div>

      <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="bg-slate-50 text-slate-500 uppercase text-[10px] font-bold">
            <tr>
              <th class="py-2.5 px-3">Nama / NISN</th>
              <th class="py-2.5 px-3">Kelas</th>
              <th class="py-2.5 px-3">Kluster Minat</th>
              <th class="py-2.5 px-3">Pilihan Penempatan</th>
              <th class="py-2.5 px-3 text-center">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @forelse($siswaList as $s)
              <tr class="hover:bg-slate-50">
                <td class="py-2.5 px-3 font-bold">{{ $s->nama }} <br><span class="text-[10px] text-slate-400">NISN: {{ $s->nisn }}</span></td>
                <td class="py-2.5 px-3">{{ $s->kelas }}</td>
                <td class="py-2.5 px-3 font-semibold text-emerald-700">{{ $s->kluster ?? '-' }}</td>
                <td class="py-2.5 px-3">{{ $s->pilihan_terkunci ?? '-' }}</td>
                <td class="py-2.5 px-3 text-center">
                  <span class="bg-emerald-100 text-emerald-800 text-[9px] px-2 py-0.5 rounded font-bold">{{ $s->status }}</span>
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="py-4 text-center text-slate-400">Belum ada data siswa di database.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </main>

  <footer class="bg-white border-t border-slate-200 py-3 text-center text-xs text-slate-400">
    QR-CAP Database Laravel &copy; {{ date('Y') }} &bull; Konsultasi Guru BK: {{ $guruKonsul['nama'] }} ({{ $guruKonsul['telepon'] }})
  </footer>

  <script>
    function switchMode(mode) {
      if (mode === 'student') {
        document.getElementById('view-student').classList.remove('hidden');
        document.getElementById('view-teacher').classList.add('hidden');
        document.getElementById('btn-mode-student').className = "px-3 py-1.5 rounded-lg text-xs font-bold bg-white text-emerald-600 shadow-sm";
        document.getElementById('btn-mode-teacher').className = "px-3 py-1.5 rounded-lg text-xs font-bold text-slate-500";
      } else {
        document.getElementById('view-teacher').classList.remove('hidden');
        document.getElementById('view-student').classList.add('hidden');
        document.getElementById('btn-mode-teacher').className = "px-3 py-1.5 rounded-lg text-xs font-bold bg-white text-emerald-600 shadow-sm";
        document.getElementById('btn-mode-student').className = "px-3 py-1.5 rounded-lg text-xs font-bold text-slate-500";
      }
    }
  </script>
</body>
</html>