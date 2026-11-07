@if(!session('guru_id'))
  @php return redirect()->route('guru.loginPage')->send(); @endphp
@endif
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Guru BK | PLBK – Pusat Layanan Bimbingan & Konseling</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; background: #f1f5f9; }

    .topbar { background: #0f2044; }

    .sidebar {
      background: white;
      border-right: 1px solid #e2e8f0;
      min-height: calc(100vh - 60px);
    }

    .sidebar-link {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 16px; border-radius: 10px;
      font-size: 13px; font-weight: 600; color: #64748b;
      transition: all 0.15s; cursor: pointer;
    }
    .sidebar-link:hover { background: #eff6ff; color: #1e4d8c; }
    .sidebar-link.active { background: #1e4d8c; color: white; }
    .sidebar-link.active i { color: #fbbf24; }

    .stat-card {
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.08); }

    .table-row { transition: background 0.1s; }
    .table-row:hover { background: #f8fafc; }

    .badge-verified { background:#dcfce7; color:#166534; }
    .badge-pending  { background:#fef3c7; color:#92400e; }

    .kluster-sains { background:#dbeafe; color:#1e40af; }
    .kluster-sosial { background:#ffedd5; color:#9a3412; }
    .kluster-seni   { background:#fce7f3; color:#9d174d; }

    .emblem { background: linear-gradient(135deg, #f5c518, #e6a817); }

    input[type="search"]::-webkit-search-cancel-button { display: none; }
  </style>
</head>
<body class="min-h-screen flex flex-col">

  <!-- TOP NAVIGATION -->
  <header class="topbar sticky top-0 z-50 shadow-lg">
    <div class="px-4 sm:px-6 py-3 flex items-center justify-between">
      <!-- Brand -->
      <div class="flex items-center space-x-3">
        <div class="emblem w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0">
          <i class="fa-solid fa-graduation-cap text-white text-base"></i>
        </div>
        <div class="leading-none">
          <p class="text-white font-extrabold text-sm">PLBK</p>
          <p class="text-blue-300 text-[10px] font-medium">Pusat Layanan Bimbingan & Konseling</p>
        </div>
      </div>

      <!-- Right actions -->
      <div class="flex items-center space-x-2 sm:space-x-3">
        <!-- Realtime indicator -->
        <div class="hidden sm:flex items-center space-x-1.5 bg-green-500/20 border border-green-400/30 px-3 py-1.5 rounded-lg">
          <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
          <span class="text-green-300 text-xs font-semibold">Live MySQL</span>
        </div>
        <!-- Nama Guru -->
        <div class="hidden sm:flex items-center space-x-1.5 bg-white/10 border border-white/20 px-3 py-1.5 rounded-lg">
          <i class="fa-solid fa-chalkboard-user text-yellow-300 text-xs"></i>
          <span class="text-white text-xs font-semibold">{{ session('guru_nama', $guruKonsul['nama']) }}</span>
        </div>
        <!-- Refresh -->
        <a href="{{ route('dashboard.guru') }}" class="flex items-center space-x-1.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold px-3 py-2 rounded-lg transition-all">
          <i class="fa-solid fa-rotate-right text-xs"></i>
          <span class="hidden sm:inline">Refresh</span>
        </a>
        <!-- Logout -->
        <a href="{{ route('guru.logout') }}" class="flex items-center space-x-1.5 bg-red-600/80 hover:bg-red-500 text-white text-xs font-semibold px-3 py-2 rounded-lg transition-all">
          <i class="fa-solid fa-right-from-bracket text-xs"></i>
          <span class="hidden sm:inline">Logout</span>
        </a>
      </div>
    </div>
  </header>

  <!-- LAYOUT -->
  <div class="flex flex-1">

    <!-- SIDEBAR -->
    <aside class="sidebar w-56 hidden lg:block flex-shrink-0 p-4 space-y-1">
      <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-2 mb-3">Menu Utama</p>
      <div class="sidebar-link active">
        <i class="fa-solid fa-chart-pie w-4 text-center"></i>
        <span>Dashboard</span>
      </div>
      <div class="sidebar-link" onclick="document.getElementById('tbl-search').focus()">
        <i class="fa-solid fa-magnifying-glass w-4 text-center"></i>
        <span>Cari Siswa</span>
      </div>

      <div class="pt-4 border-t border-slate-100">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-2 mb-3">Filter Kluster</p>
        <div class="sidebar-link" onclick="filterKluster('')">
          <i class="fa-solid fa-users w-4 text-center text-slate-400"></i>
          <span>Semua Siswa</span>
        </div>
        <div class="sidebar-link" onclick="filterKluster('Sains')">
          <i class="fa-solid fa-flask w-4 text-center text-blue-500"></i>
          <span>Sains & Teknologi</span>
        </div>
        <div class="sidebar-link" onclick="filterKluster('Sosial')">
          <i class="fa-solid fa-handshake w-4 text-center text-orange-500"></i>
          <span>Sosial & Bisnis</span>
        </div>
        <div class="sidebar-link" onclick="filterKluster('Seni')">
          <i class="fa-solid fa-palette w-4 text-center text-pink-500"></i>
          <span>Seni & Kreatif</span>
        </div>
      </div>

      <!-- Info panel Guru BK & Kontak Konseling -->
      <div class="mt-6 bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200/80 rounded-xl p-3.5 space-y-2.5">
        <div>
          <p class="text-[10px] font-extrabold text-blue-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
            <i class="fa-solid fa-headset text-xs"></i> Kontak Konseling Siswa
          </p>
          <p class="text-xs font-extrabold text-slate-800">{{ $guruKonsul['nama'] }}</p>
          <a href="tel:{{ preg_replace('/[^0-9+]/', '', $guruKonsul['telepon']) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1.5 mt-0.5">
            <i class="fa-solid fa-phone text-[10px]"></i> {{ $guruKonsul['telepon'] }}
          </a>
        </div>
        <div class="pt-2 border-t border-blue-100 flex items-center justify-between text-[10px] text-slate-500">
          <span>TA {{ date('Y') }}/{{ date('Y') + 1 }}</span>
          <span class="text-emerald-600 font-semibold flex items-center gap-1">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Online
          </span>
        </div>
      </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-4 sm:p-6 overflow-auto">
      <div class="max-w-5xl mx-auto space-y-5">

        <!-- Page title -->
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-xl font-extrabold text-slate-800">Dashboard Guru BK</h1>
            <p class="text-xs text-slate-500 mt-0.5">Rekapitulasi data asesmen siswa — Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
          </div>
          <div class="text-right hidden sm:block">
            <p class="text-xs text-slate-400">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
            <p class="text-xs font-semibold text-blue-700">Guru BK: {{ $guruKonsul['nama'] }} &bull; {{ $guruKonsul['telepon'] }}</p>
          </div>
        </div>

        @php
          $total       = $siswaList->count();
          $verified    = $siswaList->where('status','Terverifikasi')->count();
          $pending     = $siswaList->where('status','Belum Asesmen')->count();
          $sains       = $siswaList->where('kluster','Sains & Teknologi')->count();
          $sosial      = $siswaList->where('kluster','Sosial & Bisnis')->count();
          $seni        = $siswaList->where('kluster','Seni & Kreatif')->count();
          $rate        = $total > 0 ? round($verified / $total * 100) : 0;
        @endphp

        <!-- STATISTIK CARDS -->
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
          <!-- Total -->
          <div class="stat-card bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex justify-between items-start mb-3">
              <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#eff6ff">
                <i class="fa-solid fa-users text-blue-600 text-base"></i>
              </div>
              <span class="text-[10px] font-bold text-slate-400 uppercase">Total</span>
            </div>
            <p class="text-3xl font-extrabold text-slate-800">{{ $total }}</p>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Siswa Terdaftar</p>
          </div>

          <!-- Selesai -->
          <div class="stat-card bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex justify-between items-start mb-3">
              <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-green-50">
                <i class="fa-solid fa-circle-check text-green-600 text-base"></i>
              </div>
              <span class="text-[10px] font-bold text-slate-400 uppercase">Selesai</span>
            </div>
            <p class="text-3xl font-extrabold text-green-700">{{ $verified }}</p>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Terverifikasi</p>
          </div>

          <!-- Belum -->
          <div class="stat-card bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex justify-between items-start mb-3">
              <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-amber-50">
                <i class="fa-solid fa-clock text-amber-600 text-base"></i>
              </div>
              <span class="text-[10px] font-bold text-slate-400 uppercase">Pending</span>
            </div>
            <p class="text-3xl font-extrabold text-amber-600">{{ $pending }}</p>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Belum Asesmen</p>
          </div>

          <!-- Rate -->
          <div class="stat-card bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex justify-between items-start mb-3">
              <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#f0fdf4">
                <i class="fa-solid fa-chart-line text-emerald-600 text-base"></i>
              </div>
              <span class="text-[10px] font-bold text-slate-400 uppercase">Rate</span>
            </div>
            <p class="text-3xl font-extrabold text-emerald-700">{{ $rate }}%</p>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Completion Rate</p>
            <div class="mt-2 h-1.5 bg-slate-100 rounded-full">
              <div class="h-1.5 bg-emerald-500 rounded-full" style="width: {{ $rate }}%"></div>
            </div>
          </div>
        </div>

        <!-- DISTRIBUSI KLUSTER -->
        @if($total > 0)
          <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <h3 class="text-sm font-bold text-slate-700 mb-4 flex items-center space-x-2">
              <i class="fa-solid fa-chart-pie text-blue-600"></i>
              <span>Distribusi Kluster Peminatan Siswa</span>
            </h3>
            <div class="grid grid-cols-3 gap-4">
              @foreach([
                ['label'=>'Sains & Teknologi', 'val'=>$sains, 'icon'=>'fa-flask',     'bg'=>'bg-blue-50',   'border'=>'border-blue-200', 'text'=>'text-blue-700',  'bar'=>'bg-blue-500'],
                ['label'=>'Sosial & Bisnis',    'val'=>$sosial,'icon'=>'fa-handshake', 'bg'=>'bg-orange-50', 'border'=>'border-orange-200','text'=>'text-orange-700','bar'=>'bg-orange-500'],
                ['label'=>'Seni & Kreatif',     'val'=>$seni,  'icon'=>'fa-palette',   'bg'=>'bg-pink-50',   'border'=>'border-pink-200',  'text'=>'text-pink-700',  'bar'=>'bg-pink-500'],
              ] as $klus)
                <div class="{{ $klus['bg'] }} {{ $klus['border'] }} border rounded-xl p-4 text-center">
                  <div class="w-10 h-10 rounded-xl {{ $klus['bg'] }} flex items-center justify-center mx-auto mb-2 border {{ $klus['border'] }}">
                    <i class="fa-solid {{ $klus['icon'] }} {{ $klus['text'] }} text-base"></i>
                  </div>
                  <p class="text-2xl font-extrabold {{ $klus['text'] }}">{{ $klus['val'] }}</p>
                  <p class="text-[11px] font-semibold {{ $klus['text'] }} opacity-75 mt-0.5">{{ $klus['label'] }}</p>
                  @if($total > 0)
                    <div class="mt-2 h-1.5 bg-white/60 rounded-full border {{ $klus['border'] }}">
                      <div class="h-1.5 {{ $klus['bar'] }} rounded-full" style="width: {{ round($klus['val']/$total*100) }}%"></div>
                    </div>
                    <p class="text-[10px] {{ $klus['text'] }} mt-1">{{ round($klus['val']/$total*100) }}%</p>
                  @endif
                </div>
              @endforeach
            </div>
          </div>
        @endif

        <!-- TABEL DATA SISWA -->
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
          <!-- Table header -->
          <div class="px-5 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
              <h2 class="text-sm font-extrabold text-slate-800 flex items-center space-x-2">
                <i class="fa-solid fa-table-list text-blue-600"></i>
                <span>Rekap Data Asesmen Siswa</span>
              </h2>
              <p class="text-xs text-slate-400 mt-0.5">{{ $total }} siswa tercatat &bull; {{ $verified }} telah menyelesaikan asesmen</p>
            </div>
            <div class="relative">
              <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
              <input type="search" id="tbl-search" placeholder="Cari nama atau NISN..." oninput="filterTable()"
                class="pl-8 pr-4 py-2 text-xs border border-slate-200 rounded-xl bg-slate-50 focus:outline-none focus:border-blue-400 w-52">
            </div>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-left" id="siswa-table">
              <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                  @foreach(['No','Nama Siswa','Kelas','Kluster Minat','Peminatan / Penempatan','Status'] as $th)
                    <th class="py-3 px-4 text-[11px] font-extrabold text-slate-400 uppercase tracking-wider whitespace-nowrap">{{ $th }}</th>
                  @endforeach
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-50" id="siswa-tbody">
                @forelse($siswaList as $i => $s)
                  <tr class="table-row siswa-row">
                    <td class="py-3.5 px-4 text-xs text-slate-400 font-semibold">{{ $i + 1 }}</td>
                    <td class="py-3.5 px-4">
                      <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-extrabold flex-shrink-0"
                          style="background:#dbeafe; color:#1e40af;">
                          {{ strtoupper(substr($s->nama, 0, 1)) }}
                        </div>
                        <div>
                          <p class="text-sm font-bold text-slate-800 siswa-nama leading-none">{{ $s->nama }}</p>
                          <p class="text-[10px] text-slate-400 siswa-nisn mt-0.5">NISN: {{ $s->nisn }}</p>
                        </div>
                      </div>
                    </td>
                    <td class="py-3.5 px-4 text-xs text-slate-600 font-semibold">{{ $s->kelas }}</td>
                    <td class="py-3.5 px-4">
                      @if($s->kluster == 'Sains & Teknologi')
                        <span class="inline-flex items-center space-x-1.5 kluster-sains text-[11px] font-bold px-2.5 py-1 rounded-full">
                          <i class="fa-solid fa-flask text-[9px]"></i><span>{{ $s->kluster }}</span>
                        </span>
                      @elseif($s->kluster == 'Sosial & Bisnis')
                        <span class="inline-flex items-center space-x-1.5 kluster-sosial text-[11px] font-bold px-2.5 py-1 rounded-full">
                          <i class="fa-solid fa-handshake text-[9px]"></i><span>{{ $s->kluster }}</span>
                        </span>
                      @elseif($s->kluster == 'Seni & Kreatif')
                        <span class="inline-flex items-center space-x-1.5 kluster-seni text-[11px] font-bold px-2.5 py-1 rounded-full">
                          <i class="fa-solid fa-palette text-[9px]"></i><span>{{ $s->kluster }}</span>
                        </span>
                      @else
                        <span class="text-slate-300 text-xs">— Belum asesmen</span>
                      @endif
                    </td>
                    <td class="py-3.5 px-4 text-xs text-slate-600 max-w-[200px]">
                      {{ $s->pilihan_terkunci ?? '—' }}
                    </td>
                    <td class="py-3.5 px-4">
                      @if($s->status == 'Terverifikasi')
                        <span class="inline-flex items-center space-x-1.5 badge-verified text-[11px] font-bold px-2.5 py-1 rounded-full">
                          <i class="fa-solid fa-circle-check text-[9px]"></i><span>Terverifikasi</span>
                        </span>
                      @else
                        <span class="inline-flex items-center space-x-1.5 badge-pending text-[11px] font-bold px-2.5 py-1 rounded-full">
                          <i class="fa-solid fa-clock text-[9px]"></i><span>Belum Asesmen</span>
                        </span>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="py-16 text-center">
                      <div class="flex flex-col items-center space-y-3 text-slate-400">
                        <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center">
                          <i class="fa-solid fa-database text-3xl text-slate-300"></i>
                        </div>
                        <div>
                          <p class="font-bold text-slate-500">Belum ada data siswa</p>
                          <p class="text-xs mt-1">Data muncul setelah siswa melakukan asesmen</p>
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          @if($total > 0)
            <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
              <p class="text-xs text-slate-400">
                Menampilkan <strong class="text-slate-600">{{ $total }}</strong> data siswa
              </p>
              <p class="text-xs text-slate-400">
                Diperbarui: {{ now()->format('d M Y, H:i') }} WIB
              </p>
            </div>
          @endif
        </div>

      </div>
    </main>
  </div>

  <!-- FOOTER -->
  <footer class="bg-white border-t border-slate-200 py-3 px-6 flex flex-col sm:flex-row items-center justify-between gap-1">
    <p class="text-xs text-slate-400">
      <strong class="text-slate-600">PLBK</strong> — Pusat Layanan Bimbingan & Konseling &copy; {{ date('Y') }}
    </p>
    <p class="text-xs text-slate-400">Layanan Asesmen Minat, Bakat & Penempatan Peminatan Siswa</p>
  </footer>

  <script>
    function filterTable() {
      const q = document.getElementById('tbl-search').value.toLowerCase();
      document.querySelectorAll('.siswa-row').forEach(row => {
        const nama = row.querySelector('.siswa-nama').textContent.toLowerCase();
        const nisn = row.querySelector('.siswa-nisn').textContent.toLowerCase();
        row.style.display = (nama.includes(q) || nisn.includes(q)) ? '' : 'none';
      });
    }

    function filterKluster(keyword) {
      // Update sidebar active state
      document.querySelectorAll('.sidebar-link').forEach(el => el.classList.remove('active'));
      event.currentTarget.classList.add('active');

      document.querySelectorAll('.siswa-row').forEach(row => {
        if (!keyword) { row.style.display = ''; return; }
        const kluster = row.querySelector('td:nth-child(4)').textContent;
        row.style.display = kluster.includes(keyword) ? '' : 'none';
      });
    }
  </script>

</body>
</html>
