<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

  <title>Login Siswa | PLBK – Pusat Layanan Bimbingan & Konseling</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }

    .hero-bg {
      background: linear-gradient(135deg, #0f2044 0%, #1a3a6b 40%, #1e4d8c 70%, #1565c0 100%);
      position: relative;
      overflow: hidden;
    }
    .hero-bg::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -20%;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(255,200,0,0.08) 0%, transparent 70%);
      border-radius: 50%;
    }
    .hero-bg::after {
      content: '';
      position: absolute;
      bottom: -20%;
      right: -10%;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(100,160,255,0.12) 0%, transparent 70%);
      border-radius: 50%;
    }

    .emblem {
      background: linear-gradient(135deg, #f5c518, #e6a817);
      box-shadow: 0 4px 20px rgba(245, 197, 24, 0.35);
    }

    .input-elegant {
      transition: all 0.2s;
      border: 1.5px solid #e2e8f0;
    }
    .input-elegant:focus {
      border-color: #1e4d8c;
      box-shadow: 0 0 0 3px rgba(30,77,140,0.1);
      outline: none;
    }

    .btn-primary {
      background: linear-gradient(135deg, #1e4d8c, #0f2044);
      transition: all 0.25s;
    }
    .btn-primary:hover {
      background: linear-gradient(135deg, #1a3a6b, #0a1a33);
      transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(15,32,68,0.4);
    }

    .divider-ornament {
      display: flex;
      align-items: center;
      gap: 12px;
      color: #94a3b8;
    }
    .divider-ornament::before, .divider-ornament::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #e2e8f0;
    }

    .floating-card {
      animation: floatCard 4s ease-in-out infinite;
    }
    @keyframes floatCard {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-6px); }
    }

    .badge-school {
      background: rgba(255,255,255,0.12);
      border: 1px solid rgba(255,255,255,0.2);
      backdrop-filter: blur(10px);
    }
  </style>
</head>
<body class="min-h-screen flex">

  <!-- LEFT PANEL — Branding -->
  <div class="hero-bg hidden lg:flex lg:w-5/12 xl:w-1/2 flex-col justify-between p-10 xl:p-14 relative z-10">

    <!-- Top: School badge -->
    <div class="flex items-center space-x-3">
      <div class="badge-school px-4 py-2 rounded-full flex items-center space-x-2 text-white text-sm font-semibold">
        <i class="fa-solid fa-shield-halved text-yellow-300 text-base"></i>
        <span>Portal Resmi BK Sekolah</span>
      </div>
    </div>

    <!-- Middle: Brand + tagline -->
    <div class="space-y-6">
      <!-- Emblem -->
      <div class="emblem w-20 h-20 rounded-2xl flex items-center justify-center shadow-xl floating-card">
        <i class="fa-solid fa-graduation-cap text-white text-4xl"></i>
      </div>

      <div>
        <h1 class="text-5xl xl:text-6xl font-black text-white leading-tight tracking-tight" style="font-family: 'Playfair Display', serif;">
          PLBK
        </h1>
        <p class="text-yellow-300 font-bold text-lg mt-1 tracking-wide">Pusat Layanan</p>
        <p class="text-blue-200 font-semibold text-base">Bimbingan & Konseling</p>
      </div>

      <p class="text-blue-100 text-sm leading-relaxed max-w-sm">
        Platform digital terpadu untuk asesmen minat bakat, penempatan peminatan, dan
        rekapitulasi data siswa.
      </p>

      <!-- Feature list -->
      <div class="space-y-3">
        @foreach([
          ['icon' => 'fa-clipboard-question', 'text' => 'Asesmen 10 pertanyaan minat & bakat'],
          ['icon' => 'fa-chart-pie', 'text' => 'Analisis kluster peminatan otomatis'],
          ['icon' => 'fa-user-shield', 'text' => 'Dashboard rekap khusus Guru BK'],
        ] as $feat)
          <div class="flex items-center space-x-3">
            <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
              <i class="fa-solid {{ $feat['icon'] }} text-yellow-300 text-xs"></i>
            </div>
            <span class="text-blue-100 text-sm">{{ $feat['text'] }}</span>
          </div>
        @endforeach
      </div>

      <!-- Guru BK Konsul Card -->
      <div class="p-3.5 rounded-xl bg-white/10 border border-white/20 backdrop-blur flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 rounded-lg bg-yellow-400 text-slate-900 flex items-center justify-center font-bold text-base flex-shrink-0">
            <i class="fa-solid fa-headset"></i>
          </div>
          <div>
            <p class="text-[10px] text-blue-200 uppercase font-semibold">Guru Bimbingan Konseling</p>
            <p class="text-xs font-bold text-white">{{ $guruKonsul['nama'] }}</p>
            <p class="text-[11px] text-yellow-300 font-semibold">{{ $guruKonsul['telepon'] }}</p>
          </div>
        </div>
        <a href="https://wa.me/{{ $guruKonsul['wa_number'] }}?text={{ urlencode('Halo Bapak ' . $guruKonsul['nama'] . ', saya ingin konsultasi mengenai bimbingan konseling.') }}" 
           target="_blank" 
           class="w-9 h-9 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-white flex items-center justify-center transition-all shadow-md"
           title="Konsul via WhatsApp">
          <i class="fa-brands fa-whatsapp text-lg"></i>
        </a>
      </div>
    </div>

    <!-- Bottom: footer note -->
    <div class="text-blue-300 text-xs space-y-1">
      <p class="font-semibold text-blue-200">SMA/SMK Negeri &mdash; Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
      <p>Layanan Bimbingan Konseling &copy; {{ date('Y') }}</p>
    </div>
  </div>

  <!-- RIGHT PANEL — Login Form -->
  <div class="flex-1 flex flex-col justify-center items-center bg-slate-50 p-6 sm:p-10 lg:p-14">

    <!-- Mobile logo -->
    <div class="lg:hidden flex items-center space-x-3 mb-8">
      <div class="emblem w-12 h-12 rounded-xl flex items-center justify-center">
        <i class="fa-solid fa-graduation-cap text-white text-xl"></i>
      </div>
      <div>
        <h1 class="text-xl font-black text-slate-800">PLBK</h1>
        <p class="text-xs text-slate-500">Pusat Layanan Bimbingan & Konseling</p>
      </div>
    </div>

    <div class="w-full max-w-md">

      <!-- Form header -->
      <div class="mb-8">
        <h2 class="text-2xl font-extrabold text-slate-800">Selamat Datang</h2>
        <p class="text-slate-500 text-sm mt-1">Masuk menggunakan Nama dan NISN Anda</p>
      </div>

      {{-- Error Messages --}}
      @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 text-xs font-medium px-4 py-3 rounded-xl mb-5 flex items-center space-x-2">
          <i class="fa-solid fa-circle-exclamation text-red-400"></i>
          <span>{{ session('error') }}</span>
        </div>
      @endif
      @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-xs font-medium px-4 py-3 rounded-xl mb-5">
          @foreach($errors->all() as $err)
            <div class="flex items-center space-x-2"><i class="fa-solid fa-triangle-exclamation text-red-400"></i><span>{{ $err }}</span></div>
          @endforeach
        </div>
      @endif

      <!-- Form -->
      <form action="{{ route('siswa.login') }}" method="POST" class="space-y-5">
        @csrf

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
              <i class="fa-solid fa-user text-slate-400 text-sm"></i>
            </div>
            <input
              type="text"
              name="nama"
              id="nama"
              required
              autocomplete="name"
              placeholder="Masukkan nama lengkap Anda"
              value="{{ old('nama') }}"
              class="input-elegant w-full pl-10 pr-4 py-3 rounded-xl bg-white text-sm text-slate-800"
            >
          </div>
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">Kelas</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
              <i class="fa-solid fa-school text-slate-400 text-sm"></i>
            </div>
            <input
              type="text"
              name="kelas"
              id="kelas"
              placeholder="Contoh: X-1, XI IPA 2, XII IPS 1 (Opsional)"
              value="{{ old('kelas') }}"
              class="input-elegant w-full pl-10 pr-4 py-3 rounded-xl bg-white text-sm text-slate-800"
            >
          </div>
        </div>

        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-2">NISN</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
              <i class="fa-solid fa-id-card text-slate-400 text-sm"></i>
            </div>
            <input
              type="number"
              name="nisn"
              id="nisn"
              required
              placeholder="Nomor Induk Siswa Nasional"
              value="{{ old('nisn') }}"
              class="input-elegant w-full pl-10 pr-4 py-3 rounded-xl bg-white text-sm text-slate-800"
            >
          </div>
          <p class="text-xs text-slate-400 mt-1.5">Jika NISN belum terdaftar, akun baru akan dibuat otomatis.</p>
        </div>

        <button type="submit" id="btn-login" class="btn-primary w-full text-white font-bold py-3.5 rounded-xl text-sm mt-2">
          <i class="fa-solid fa-right-to-bracket mr-2"></i>
          Masuk ke Portal Siswa
        </button>
      </form>

      <div class="divider-ornament my-6 text-xs">atau</div>

      <!-- Guru BK link -->
      <a href="{{ route('dashboard.guru') }}" class="flex items-center justify-center space-x-2.5 w-full border-2 border-slate-200 hover:border-blue-300 hover:bg-blue-50 text-slate-600 hover:text-blue-700 font-semibold py-3 rounded-xl text-sm transition-all group">
        <div class="w-7 h-7 rounded-lg bg-slate-100 group-hover:bg-blue-100 flex items-center justify-center transition-all">
          <i class="fa-solid fa-chalkboard-user text-slate-500 group-hover:text-blue-600 text-xs transition-all"></i>
        </div>
        <span>Masuk sebagai Guru BK</span>
        <i class="fa-solid fa-arrow-right text-xs opacity-0 group-hover:opacity-100 -translate-x-1 group-hover:translate-x-0 transition-all"></i>
      </a>

      <!-- Info Kontak Konsul Guru BK -->
      <div class="mt-5 p-3.5 rounded-2xl bg-white border border-slate-200 shadow-sm flex items-center justify-between gap-3">
        <div class="flex items-center space-x-3">
          <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-sm flex-shrink-0">
            <i class="fa-solid fa-headset"></i>
          </div>
          <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Konsultasi Guru BK</p>
            <p class="text-xs font-extrabold text-slate-800">{{ $guruKonsul['nama'] }}</p>
            <p class="text-[11px] font-semibold text-blue-700">{{ $guruKonsul['telepon'] }}</p>
          </div>
        </div>
        <a href="https://wa.me/{{ $guruKonsul['wa_number'] }}?text={{ urlencode('Halo Bapak ' . $guruKonsul['nama'] . ', saya ingin bertanya atau konsultasi seputar BK.') }}" 
           target="_blank" 
           class="inline-flex items-center space-x-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 px-3 py-1.5 rounded-xl text-xs font-bold transition-all">
          <i class="fa-brands fa-whatsapp text-sm"></i>
          <span>Konsul</span>
        </a>
      </div>

      <p class="text-center text-xs text-slate-400 mt-8">
        Pusat Layanan Bimbingan & Konseling &copy; {{ date('Y') }}<br>
        <span class="font-medium text-slate-500">Layanan Asesmen Minat & Penempatan Peminatan</span>
      </p>
    </div>
  </div>

</body>
</html>
