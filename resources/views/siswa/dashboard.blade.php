<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Asesmen Siswa | PLBK</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; background: #f1f5f9; }

    .topbar { background: #0f2044; }

    .input-elegant { transition: all 0.2s; border: 1.5px solid #e2e8f0; }
    .input-elegant:focus { border-color: #1e4d8c; box-shadow: 0 0 0 3px rgba(30,77,140,0.1); outline: none; }

    .radio-option {
      display: flex; align-items: flex-start; gap: 10px;
      padding: 10px 14px; border-radius: 10px;
      border: 1.5px solid #e2e8f0; cursor: pointer;
      transition: all 0.15s; background: white;
    }
    .radio-option:hover { border-color: #1e4d8c; background: #eff6ff; }
    .radio-option input[type="radio"]:checked ~ * { color: #1e4d8c; }

    .q-card { border-left: 3px solid #1e4d8c; }

    .btn-submit {
      background: linear-gradient(135deg, #1e4d8c, #0f2044);
      transition: all 0.25s;
    }
    .btn-submit:hover {
      box-shadow: 0 8px 24px rgba(15,32,68,0.4);
      transform: translateY(-1px);
    }

    .status-badge {
      background: linear-gradient(135deg, #f5c518, #e6a817);
    }

    /* Progress bar */
    #prog-fill { transition: width 0.4s ease; }

    /* Step number badge */
    .step-num {
      min-width: 24px; height: 24px;
      background: #1e4d8c; color: white;
      border-radius: 50%;
      display: inline-flex; align-items: center; justify-content: center;
      font-size: 11px; font-weight: 800;
      flex-shrink: 0;
    }
  </style>
</head>
<body class="min-h-screen flex flex-col">

  <!-- TOP NAVIGATION BAR -->
  <header class="topbar sticky top-0 z-50 shadow-lg">
    <div class="max-w-4xl mx-auto px-4 py-3 flex items-center justify-between">
      <!-- Brand -->
      <div class="flex items-center space-x-3">
        <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background:linear-gradient(135deg,#f5c518,#e6a817);">
          <i class="fa-solid fa-graduation-cap text-white text-base"></i>
        </div>
        <div>
          <p class="text-white font-extrabold text-sm leading-none">PLBK</p>
          <p class="text-blue-300 text-[10px] leading-none font-medium">Portal Siswa — Asesmen & Penempatan</p>
        </div>
      </div>

      <!-- User info + logout -->
      <div class="flex items-center space-x-2 sm:space-x-3">
        <div class="hidden sm:flex items-center space-x-2 bg-white/10 border border-white/20 px-3 py-1.5 rounded-lg">
          <div class="w-6 h-6 rounded-full bg-yellow-400 text-slate-900 flex items-center justify-center text-[10px] font-extrabold">
            {{ strtoupper(substr($currentSiswa->nama, 0, 1)) }}
          </div>
          <div class="leading-none">
            <p class="text-white text-xs font-semibold">{{ Str::limit($currentSiswa->nama, 18) }}</p>
            <p class="text-blue-300 text-[10px]">NISN: {{ $currentSiswa->nisn }}</p>
          </div>
        </div>
        <a href="{{ route('siswa.logout') }}" class="flex items-center space-x-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-2 rounded-lg transition-all">
          <i class="fa-solid fa-right-from-bracket text-xs"></i>
          <span class="hidden sm:inline">Keluar</span>
        </a>
      </div>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main class="flex-grow py-6 px-4">
    <div class="max-w-3xl mx-auto space-y-5">

      {{-- Flash Messages --}}
      @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 text-sm font-semibold px-5 py-3.5 rounded-xl flex items-center space-x-2.5 shadow-sm">
          <i class="fa-solid fa-circle-check text-green-500 text-base flex-shrink-0"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif
      @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm font-semibold px-5 py-3.5 rounded-xl flex items-center space-x-2.5">
          <i class="fa-solid fa-circle-exclamation text-red-400 flex-shrink-0"></i>
          <span>{{ session('error') }}</span>
        </div>
      @endif

      @if($currentSiswa->status == 'Terverifikasi')
        {{-- ===== HASIL ASESMEN ===== --}}

        <!-- Header Hasil -->
        <div class="bg-gradient-to-r from-[#0f2044] to-[#1e4d8c] rounded-2xl p-6 text-white shadow-xl">
          <div class="flex items-start space-x-4">
            <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#f5c518,#e6a817);">
              <i class="fa-solid fa-circle-check text-white text-2xl"></i>
            </div>
            <div>
              <span class="inline-block bg-green-400 text-green-900 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full mb-2 uppercase tracking-wide">Asesmen Selesai</span>
              <h2 class="text-xl font-extrabold leading-snug">Hasil Asesmen Minat & Bakat</h2>
              <p class="text-blue-200 text-xs mt-1">Data berhasil disimpan ke database. Berikut hasil analisis Anda.</p>
            </div>
          </div>
        </div>

        <!-- Kartu Hasil -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kluster Minat Dominan</p>
            <p class="text-2xl font-extrabold text-blue-800 leading-tight">{{ $currentSiswa->kluster }}</p>
            <div class="mt-3 h-1 rounded-full bg-blue-100">
              <div class="h-1 rounded-full bg-blue-600" style="width: 80%"></div>
            </div>
          </div>
          <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pilihan Penempatan</p>
            <p class="text-base font-extrabold text-amber-700 leading-snug">{{ $currentSiswa->pilihan_terkunci }}</p>
          </div>
        </div>

        <!-- KARTU KONSULTASI GURU BK -->
        <div class="bg-gradient-to-br from-[#0f2044] via-[#163567] to-[#1e4d8c] rounded-2xl p-5 sm:p-6 text-white shadow-xl border border-blue-400/20 relative overflow-hidden">
          <div class="absolute -right-10 -bottom-10 w-44 h-44 bg-blue-400/10 rounded-full blur-2xl pointer-events-none"></div>
          
          <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-5 relative z-10">
            <div class="flex items-start space-x-4">
              <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg text-slate-900" style="background:linear-gradient(135deg,#f5c518,#e6a817);">
                <i class="fa-solid fa-comments text-2xl"></i>
              </div>
              <div>
                <div class="flex items-center gap-2 mb-1 flex-wrap">
                  <span class="inline-flex items-center gap-1.5 bg-yellow-400/20 text-yellow-300 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider border border-yellow-400/30">
                    <i class="fa-solid fa-headset text-xs"></i> Layanan Konsultasi BK
                  </span>
                  <span class="inline-flex items-center gap-1 bg-emerald-500/20 text-emerald-300 text-[10px] font-bold px-2 py-0.5 rounded-full border border-emerald-400/30">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Bimbingan Konseling Aktif
                  </span>
                </div>
                <h3 class="text-lg font-extrabold text-white">Butuh Konsultasi Minat & Peminatan?</h3>
                <p class="text-xs text-blue-200 mt-1 max-w-xl leading-relaxed">
                  Diskusikan hasil asesmen minat bakat Anda bersama Guru Bimbingan Konseling untuk menentukan langkah studi terbaik.
                </p>

                <!-- Data Guru BK -->
                <div class="mt-4 p-3.5 bg-white/10 rounded-xl border border-white/15 flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-6">
                  <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/30 flex items-center justify-center text-yellow-300">
                      <i class="fa-solid fa-chalkboard-user text-sm"></i>
                    </div>
                    <div>
                      <p class="text-[10px] text-blue-300 uppercase font-semibold">Nama Guru BK</p>
                      <p class="text-sm font-extrabold text-white">{{ $guruKonsul['nama'] }}</p>
                    </div>
                  </div>

                  <div class="h-6 w-px bg-white/20 hidden sm:block"></div>

                  <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/30 flex items-center justify-center text-emerald-300">
                      <i class="fa-solid fa-phone text-sm"></i>
                    </div>
                    <div>
                      <p class="text-[10px] text-blue-300 uppercase font-semibold">Nomor Telepon Konsul</p>
                      <p class="text-sm font-extrabold text-white tracking-wide">{{ $guruKonsul['telepon'] }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tombol Konsultasi -->
            <div class="flex flex-row md:flex-col gap-2.5 w-full md:w-auto flex-shrink-0">
              <a href="https://wa.me/{{ $guruKonsul['wa_number'] }}?text={{ urlencode('Halo Bapak ' . $guruKonsul['nama'] . ', saya ' . $currentSiswa->nama . ' (NISN: ' . $currentSiswa->nisn . ', Kelas: ' . $currentSiswa->kelas . '). Saya ingin berkonsultasi mengenai hasil asesmen minat bakat saya (' . $currentSiswa->kluster . ' - ' . $currentSiswa->pilihan_terkunci . ').') }}" 
                 target="_blank" 
                 class="flex-1 md:flex-initial inline-flex items-center justify-center space-x-2 bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-5 py-3 rounded-xl text-xs sm:text-sm shadow-lg hover:shadow-emerald-600/30 transition-all">
                <i class="fa-brands fa-whatsapp text-base"></i>
                <span>Konsul via WA</span>
              </a>
              <a href="tel:{{ preg_replace('/[^0-9+]/', '', $guruKonsul['telepon']) }}" 
                 class="flex-1 md:flex-initial inline-flex items-center justify-center space-x-2 bg-white/10 hover:bg-white/20 border border-white/25 text-white font-semibold px-4 py-3 rounded-xl text-xs sm:text-sm transition-all">
                <i class="fa-solid fa-phone text-xs"></i>
                <span>Telepon Guru</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Detail siswa -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
          <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center space-x-2">
            <i class="fa-solid fa-circle-user text-blue-600"></i>
            <span>Data Pribadi Siswa</span>
          </h3>
          <div class="divide-y divide-slate-100">
            @foreach(['Nama' => $currentSiswa->nama, 'NISN' => $currentSiswa->nisn, 'Kelas' => $currentSiswa->kelas, 'Status' => $currentSiswa->status] as $label => $val)
              <div class="flex justify-between items-center py-2.5 text-sm">
                <span class="text-slate-500 font-medium">{{ $label }}</span>
                <span class="font-bold text-slate-800 {{ $label === 'Status' ? 'text-green-600' : '' }}">{{ $val }}</span>
              </div>
            @endforeach
          </div>
        </div>

        <!-- Action buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
          <form action="{{ route('siswa.reset') }}" method="POST" class="flex-1">
            @csrf
            <button type="submit" class="w-full bg-white hover:bg-slate-50 text-slate-700 font-bold py-3 rounded-xl text-sm border-2 border-slate-200 hover:border-slate-300 transition-all">
              <i class="fa-solid fa-rotate-left mr-2 text-slate-500"></i>Ulangi Asesmen
            </button>
          </form>
          <a href="{{ route('siswa.logout') }}" class="flex-1 btn-submit text-white font-bold py-3 rounded-xl text-sm text-center flex items-center justify-center">
            <i class="fa-solid fa-right-from-bracket mr-2"></i>Selesai & Keluar
          </a>
        </div>

      @else
        {{-- ===== FORM ASESMEN ===== --}}

        <!-- Header Form -->
        <div class="bg-gradient-to-r from-[#0f2044] to-[#1e4d8c] rounded-2xl p-6 text-white shadow-xl">
          <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
              <span class="inline-block bg-yellow-400 text-yellow-900 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full mb-2 uppercase tracking-wide">
                <i class="fa-solid fa-clipboard-question mr-1"></i>Form Asesmen
              </span>
              <h2 class="text-xl font-extrabold">Asesmen Minat & Bakat Siswa</h2>
              <p class="text-blue-200 text-xs mt-1">Isi 10 pertanyaan berikut dengan jujur dan sesuai kondisi diri Anda.</p>
            </div>
            <div class="text-right">
              <p class="text-blue-200 text-[11px] mb-1">Progress Pengisian</p>
              <div class="w-36 h-2 bg-white/20 rounded-full">
                <div id="prog-fill" class="h-2 bg-yellow-400 rounded-full" style="width:0%"></div>
              </div>
              <p class="text-yellow-300 text-[11px] mt-1 font-bold"><span id="prog-count">0</span>/10 dijawab</p>
            </div>
          </div>
        </div>

        <!-- Banner Kontak Konsul Guru BK -->
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-sm">
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-blue-700 text-yellow-300 flex items-center justify-center flex-shrink-0 shadow-sm">
              <i class="fa-solid fa-headset text-base"></i>
            </div>
            <div>
              <p class="text-xs font-bold text-slate-800">Butuh Bantuan atau Konsultasi Pengisian?</p>
              <p class="text-[11px] text-slate-600">
                Hubungi Guru BK: <strong class="text-blue-900 font-extrabold">{{ $guruKonsul['nama'] }}</strong> &bull; Telepon/WA: <a href="tel:{{ preg_replace('/[^0-9+]/', '', $guruKonsul['telepon']) }}" class="font-bold text-blue-700 hover:underline">{{ $guruKonsul['telepon'] }}</a>
              </p>
            </div>
          </div>
          <a href="https://wa.me/{{ $guruKonsul['wa_number'] }}?text={{ urlencode('Halo Bapak ' . $guruKonsul['nama'] . ', saya ' . $currentSiswa->nama . ' (NISN: ' . $currentSiswa->nisn . '). Saya ingin bertanya atau berkonsultasi seputar asesmen minat bakat.') }}" 
             target="_blank" 
             class="inline-flex items-center space-x-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition-all shadow-sm flex-shrink-0">
            <i class="fa-brands fa-whatsapp text-sm"></i>
            <span>Konsul Guru BK</span>
          </a>
        </div>

        <!-- Form -->
        <form action="{{ route('siswa.assessment') }}" method="POST" id="assessment-form" class="space-y-4">
          @csrf

          <!-- Kelas Siswa -->
          <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <label class="block text-sm font-bold text-slate-700 mb-2">
              <i class="fa-solid fa-school text-blue-600 mr-1.5"></i>Kelas Anda
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                <i class="fa-solid fa-chalkboard-user text-slate-400 text-sm"></i>
              </div>
              <input 
                type="text" 
                name="kelas" 
                id="input-kelas" 
                required 
                placeholder="Masukkan kelas Anda (Contoh: X-1, XI IPA 3, XII IPS 2)" 
                value="{{ old('kelas', ($currentSiswa && $currentSiswa->kelas !== '-') ? $currentSiswa->kelas : '') }}" 
                class="input-elegant w-full pl-10 pr-4 py-3 rounded-xl bg-white text-sm text-slate-800 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-600"
              >
            </div>
            <p class="text-xs text-slate-400 mt-1.5">Ketikkan nama kelas Anda secara manual.</p>
          </div>

          {{-- 10 Pertanyaan --}}
          @php
            $questions = [
              ['q'=>'q1',  'text'=>'Aktivitas apa yang paling memicu semangat dan minat Anda?',
               'opts'=>['sains'=>'Analisis logika, coding, atau eksperimen sains','sosial'=>'Diskusi, negosiasi, kepemimpinan & organisasi','seni'=>'Menggambar, desain visual, atau seni musik']],
              ['q'=>'q2',  'text'=>'Mata pelajaran mana yang paling konsisten nilai Anda tinggi?',
               'opts'=>['sains'=>'Matematika, Fisika, Biologi, atau Informatika','sosial'=>'Ekonomi, Sosiologi, Geografi, atau Sejarah','seni'=>'Seni Budaya, Prakarya, atau Bahasa']],
              ['q'=>'q3',  'text'=>'Bagaimana gaya belajar yang paling efektif untuk Anda?',
               'opts'=>['sains'=>'Sistematis, berbasis data & pembuktian ilmiah','sosial'=>'Diskusi kelompok aktif & interaksi sosial','seni'=>'Eksploratif, fleksibel, dan mengutamakan estetika']],
              ['q'=>'q4',  'text'=>'Jika diberi waktu bebas, proyek apa yang ingin Anda buat?',
               'opts'=>['sains'=>'Aplikasi software, website, atau robot otomatis','sosial'=>'Kampanye sosial, riset masyarakat, atau bisnis startup','seni'=>'Pameran seni, film pendek, musik, atau desain brand']],
              ['q'=>'q5',  'text'=>'Topik bacaan atau konten apa yang paling sering Anda konsumsi?',
               'opts'=>['sains'=>'Teknologi, sains antariksa, AI, atau algoritma','sosial'=>'Psikologi manusia, ekonomi, atau biografi tokoh','seni'=>'Fotografi, arsitektur, desain, atau sejarah seni']],
              ['q'=>'q6',  'text'=>'Saat menghadapi masalah kompleks, apa langkah pertama Anda?',
               'opts'=>['sains'=>'Mengumpulkan data, mencari pola, dan menguji hipotesis','sosial'=>'Mengajak orang berdiskusi dan mencari mufakat bersama','seni'=>'Mencari sudut pandang unik dan pendekatan kreatif']],
              ['q'=>'q7',  'text'=>'Ekstrakurikuler mana yang paling menarik minat Anda?',
               'opts'=>['sains'=>'KIR (Karya Ilmiah Remaja) / Robotik / Olimpiade Sains','sosial'=>'Debat / OSIS / PMR / Pramuka','seni'=>'Teater / Seni Lukis / Desain Grafis / Paduan Suara']],
              ['q'=>'q8',  'text'=>'Lingkungan kerja seperti apa yang Anda impikan di masa depan?',
               'opts'=>['sains'=>'Lab riset, kantor teknologi, atau studio coding','sosial'=>'Lembaga pemerintah, korporat, atau organisasi nirlaba','seni'=>'Studio kreatif, agensi desain, atau production house']],
              ['q'=>'q9',  'text'=>'Platform atau komunitas digital mana yang paling aktif Anda ikuti?',
               'opts'=>['sains'=>'GitHub, Kaggle, StackOverflow, atau kanal sains/teknik','sosial'=>'LinkedIn, portal berita ekonomi-bisnis, atau forum debat','seni'=>'Behance, Dribbble, Instagram Art, Pinterest, atau YouTube creator']],
              ['q'=>'q10', 'text'=>'Profesi mana yang paling mendekati impian karier Anda?',
               'opts'=>['sains'=>'Software Engineer / Dokter / Peneliti / Data Scientist','sosial'=>'Psikolog / Diplomat / Entrepreneur / Manajer / Pengacara','seni'=>'Creative Director / Animator / Desainer / Fotografer / Penulis']],
            ];
          @endphp

          @foreach($questions as $i => $q)
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm q-card">
              <p class="text-sm font-bold text-slate-800 mb-3 flex items-start space-x-2.5">
                <span class="step-num mt-0.5">{{ $i + 1 }}</span>
                <span>{{ $q['text'] }}</span>
              </p>
              <div class="space-y-2 ml-8">
                @foreach($q['opts'] as $val => $label)
                  <label class="radio-option text-sm text-slate-700">
                    <input type="radio" name="{{ $q['q'] }}" value="{{ $val }}" required
                      class="mt-0.5 accent-blue-700 flex-shrink-0"
                      onchange="updateProgress()">
                    <span>{{ $label }}</span>
                  </label>
                @endforeach
              </div>
            </div>
          @endforeach

          <!-- Pilihan Penempatan Final -->
          <div class="bg-amber-50 border-2 border-amber-300 rounded-2xl p-5 shadow-sm">
            <label class="block text-sm font-bold text-amber-800 mb-2">
              <i class="fa-solid fa-star text-amber-500 mr-1.5"></i>Pilihan Penempatan Peminatan Final
            </label>
            <p class="text-xs text-amber-600 mb-3">Pilih jurusan / peminatan yang paling sesuai dengan impian Anda.</p>
            <select name="pilihan_akhir" required class="input-elegant w-full px-4 py-3 rounded-xl bg-white text-sm text-slate-800">
              <option value="" disabled selected>— Pilih peminatan —</option>
              <option value="Teknik Informatika & Robotik">Teknik Informatika & Robotik</option>
              <option value="Kedokteran & Ilmu Kesehatan">Kedokteran & Ilmu Kesehatan</option>
              <option value="Teknik Sipil & Arsitektur">Teknik Sipil & Arsitektur</option>
              <option value="Psikologi & Manajemen Bisnis">Psikologi & Manajemen Bisnis</option>
              <option value="Hukum & Ilmu Sosial">Hukum & Ilmu Sosial</option>
              <option value="Ekonomi & Akuntansi">Ekonomi & Akuntansi</option>
              <option value="Desain Komunikasi Visual (DKV) & Seni">Desain Komunikasi Visual (DKV) & Seni</option>
              <option value="Seni Pertunjukan & Musik">Seni Pertunjukan & Musik</option>
            </select>
          </div>

          <!-- Submit -->
          <button type="submit" id="btn-submit" class="btn-submit w-full text-white font-bold py-4 rounded-2xl text-sm shadow-xl">
            <i class="fa-solid fa-paper-plane mr-2"></i>Kirim & Simpan Hasil Asesmen
          </button>
        </form>

      @endif
    </div>
  </main>

  <footer class="bg-white border-t border-slate-200 py-3 text-center text-xs text-slate-400">
    PLBK — Pusat Layanan Bimbingan & Konseling &copy; {{ date('Y') }} &bull; Kontak Konsul: <strong class="text-slate-600">{{ $guruKonsul['nama'] }}</strong> ({{ $guruKonsul['telepon'] }})
  </footer>

  <script>
    function updateProgress() {
      let answered = 0;
      for (let i = 1; i <= 10; i++) {
        if (document.querySelector(`input[name="q${i}"]:checked`)) answered++;
      }
      document.getElementById('prog-fill').style.width = (answered / 10 * 100) + '%';
      document.getElementById('prog-count').textContent = answered;
    }
  </script>
</body>
</html>
