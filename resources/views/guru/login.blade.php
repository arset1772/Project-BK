<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

  <title>Login Guru BK | PLBK – Pusat Layanan Bimbingan & Konseling</title>
  <meta name="description" content="Halaman login khusus Guru BK untuk mengakses dashboard rekapitulasi asesmen siswa.">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #0a1628;
      position: relative;
      overflow: hidden;
    }

    /* ── Animated background ── */
    .bg-orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      opacity: 0.18;
      animation: floatOrb 8s ease-in-out infinite;
    }
    .bg-orb-1 { width: 500px; height: 500px; background: #1e4d8c; top: -120px; left: -120px; animation-delay: 0s; }
    .bg-orb-2 { width: 400px; height: 400px; background: #0f6b3f; bottom: -80px; right: -80px; animation-delay: 3s; }
    .bg-orb-3 { width: 300px; height: 300px; background: #7c3aed; top: 40%; left: 60%; animation-delay: 1.5s; }

    @keyframes floatOrb {
      0%, 100% { transform: translateY(0) scale(1); }
      50% { transform: translateY(-30px) scale(1.05); }
    }

    /* ── Grid dots overlay ── */
    body::before {
      content: '';
      position: absolute;
      inset: 0;
      background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px);
      background-size: 28px 28px;
      pointer-events: none;
    }

    /* ── Card ── */
    .login-wrapper {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 420px;
      padding: 20px;
    }

    .login-card {
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 24px;
      padding: 40px 36px;
      backdrop-filter: blur(20px);
      box-shadow: 0 32px 80px rgba(0,0,0,0.5);
    }

    /* ── Logo / Header ── */
    .logo-ring {
      width: 64px; height: 64px;
      border-radius: 18px;
      background: linear-gradient(135deg, #1e4d8c, #0f6b3f);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 20px;
      box-shadow: 0 8px 24px rgba(30,77,140,0.4);
      animation: logoPulse 3s ease-in-out infinite;
    }
    @keyframes logoPulse {
      0%, 100% { box-shadow: 0 8px 24px rgba(30,77,140,0.4); }
      50% { box-shadow: 0 8px 40px rgba(30,77,140,0.7); }
    }

    .badge-guru {
      display: inline-flex; align-items: center; gap: 6px;
      background: rgba(30,77,140,0.25);
      border: 1px solid rgba(30,77,140,0.5);
      color: #7db3f5;
      font-size: 11px; font-weight: 700;
      padding: 4px 12px; border-radius: 20px;
      letter-spacing: 0.05em;
      text-transform: uppercase;
      margin-bottom: 10px;
    }

    h1 {
      color: #fff;
      font-size: 22px; font-weight: 800;
      letter-spacing: -0.5px;
      margin-bottom: 6px;
      text-align: center;
    }
    .subtitle {
      color: rgba(255,255,255,0.4);
      font-size: 13px; text-align: center;
      margin-bottom: 32px;
    }

    /* ── Alert Error ── */
    .alert-error {
      display: flex; align-items: center; gap: 10px;
      background: rgba(239,68,68,0.12);
      border: 1px solid rgba(239,68,68,0.3);
      border-radius: 12px;
      padding: 12px 14px;
      margin-bottom: 20px;
      animation: shakeAlert 0.4s ease;
    }
    @keyframes shakeAlert {
      0%,100% { transform: translateX(0); }
      25% { transform: translateX(-6px); }
      75% { transform: translateX(6px); }
    }
    .alert-error i { color: #f87171; font-size: 14px; }
    .alert-error span { color: #fca5a5; font-size: 13px; font-weight: 500; }

    /* ── Alert Success ── */
    .alert-success {
      display: flex; align-items: center; gap: 10px;
      background: rgba(34,197,94,0.12);
      border: 1px solid rgba(34,197,94,0.3);
      border-radius: 12px;
      padding: 12px 14px;
      margin-bottom: 20px;
    }
    .alert-success i { color: #4ade80; font-size: 14px; }
    .alert-success span { color: #86efac; font-size: 13px; font-weight: 500; }

    /* ── Form ── */
    .form-group { margin-bottom: 18px; }

    label {
      display: block;
      color: rgba(255,255,255,0.6);
      font-size: 12px; font-weight: 600;
      text-transform: uppercase; letter-spacing: 0.06em;
      margin-bottom: 8px;
    }

    .input-wrap {
      position: relative;
    }
    .input-icon {
      position: absolute;
      left: 14px; top: 50%; transform: translateY(-50%);
      color: rgba(255,255,255,0.3);
      font-size: 14px;
      pointer-events: none;
      transition: color 0.2s;
    }
    .toggle-pw {
      position: absolute;
      right: 14px; top: 50%; transform: translateY(-50%);
      color: rgba(255,255,255,0.3);
      font-size: 14px;
      cursor: pointer;
      transition: color 0.2s;
      background: none; border: none; padding: 0;
    }
    .toggle-pw:hover { color: rgba(255,255,255,0.7); }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.1);
      border-radius: 12px;
      color: #fff;
      font-family: 'Inter', sans-serif;
      font-size: 14px;
      padding: 13px 44px 13px 42px;
      outline: none;
      transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
    }
    input[type="text"]::placeholder,
    input[type="password"]::placeholder { color: rgba(255,255,255,0.2); }

    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: rgba(30,77,140,0.7);
      background: rgba(30,77,140,0.1);
      box-shadow: 0 0 0 3px rgba(30,77,140,0.2);
    }
    input[type="text"]:focus ~ .input-icon,
    input[type="password"]:focus ~ .input-icon { color: #7db3f5; }

    /* ── Submit button ── */
    .btn-login {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #1e4d8c, #1a6b3c);
      border: none; border-radius: 12px;
      color: #fff; font-family: 'Inter', sans-serif;
      font-size: 15px; font-weight: 700;
      cursor: pointer;
      margin-top: 8px;
      transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
      box-shadow: 0 6px 24px rgba(30,77,140,0.35);
      display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 32px rgba(30,77,140,0.5);
    }
    .btn-login:active {
      transform: translateY(0);
      opacity: 0.9;
    }

    /* ── Divider ── */
    .divider {
      display: flex; align-items: center; gap: 12px;
      margin: 24px 0 18px;
    }
    .divider-line { flex: 1; height: 1px; background: rgba(255,255,255,0.08); }
    .divider-text { color: rgba(255,255,255,0.25); font-size: 11px; font-weight: 600; }

    /* ── Portal link ── */
    .portal-link {
      display: flex; align-items: center; justify-content: center; gap: 8px;
      text-decoration: none;
      color: rgba(255,255,255,0.45);
      font-size: 13px; font-weight: 500;
      padding: 12px;
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 12px;
      transition: all 0.2s;
    }
    .portal-link:hover {
      color: rgba(255,255,255,0.75);
      border-color: rgba(255,255,255,0.18);
      background: rgba(255,255,255,0.04);
    }

    /* ── Footer ── */
    .card-footer {
      margin-top: 28px;
      padding-top: 18px;
      border-top: 1px solid rgba(255,255,255,0.07);
      text-align: center;
      color: rgba(255,255,255,0.2);
      font-size: 11px;
    }
    .card-footer strong { color: rgba(255,255,255,0.35); }

    /* ── Loading state ── */
    .btn-login.loading { opacity: 0.7; pointer-events: none; }
  </style>
</head>
<body>

  <!-- Background orbs -->
  <div class="bg-orb bg-orb-1"></div>
  <div class="bg-orb bg-orb-2"></div>
  <div class="bg-orb bg-orb-3"></div>

  <div class="login-wrapper">
    <div class="login-card">

      <!-- Logo -->
      <div class="logo-ring">
        <i class="fa-solid fa-chalkboard-user" style="color:#fff; font-size:26px;"></i>
      </div>

      <!-- Badge & Title -->
      <div style="text-align:center; margin-bottom:6px;">
        <span class="badge-guru">
          <i class="fa-solid fa-shield-halved"></i>
          Akses Khusus Guru BK
        </span>
      </div>
      <h1>Login Guru BK</h1>
      <p class="subtitle">Masukkan kredensial Anda untuk mengakses<br>dashboard rekapitulasi asesmen siswa</p>

      <!-- Alert Error -->
      @if(session('error'))
        <div class="alert-error">
          <i class="fa-solid fa-circle-xmark"></i>
          <span>{{ session('error') }}</span>
        </div>
      @endif

      <!-- Alert Success (misal setelah logout) -->
      @if(session('success'))
        <div class="alert-success">
          <i class="fa-solid fa-circle-check"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      <!-- Form Login -->
      <form id="login-form" action="{{ route('guru.login') }}" method="POST" onsubmit="handleSubmit(this)">
        @csrf

        <!-- Username -->
        <div class="form-group">
          <label for="username">Username</label>
          <div class="input-wrap">
            <input
              type="text"
              id="username"
              name="username"
              placeholder="Masukkan username"
              value="{{ old('username') }}"
              autocomplete="username"
              required
            >
            <i class="fa-solid fa-user input-icon"></i>
          </div>
        </div>

        <!-- Password -->
        <div class="form-group">
          <label for="password">Password</label>
          <div class="input-wrap">
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Masukkan password"
              autocomplete="current-password"
              required
            >
            <i class="fa-solid fa-lock input-icon"></i>
            <button type="button" class="toggle-pw" onclick="togglePw()" id="pw-toggle" aria-label="Tampilkan password">
              <i class="fa-solid fa-eye" id="pw-icon"></i>
            </button>
          </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-login" id="btn-submit">
          <i class="fa-solid fa-right-to-bracket"></i>
          <span>Masuk ke Dashboard</span>
        </button>
      </form>

      <!-- Divider -->
      <div class="divider">
        <div class="divider-line"></div>
        <span class="divider-text">atau</span>
        <div class="divider-line"></div>
      </div>

      <!-- Link ke Portal Siswa -->
      <a href="{{ route('siswa.loginPage') }}" class="portal-link">
        <i class="fa-solid fa-user-graduate"></i>
        Masuk sebagai Siswa
      </a>

      <!-- Footer -->
      <div class="card-footer">
        <strong>PLBK</strong> — Pusat Layanan Bimbingan & Konseling &copy; {{ date('Y') }}<br>
        <span style="font-size:10px; color:rgba(255,255,255,0.4); margin-top:4px; display:inline-block;">
          Guru BK: <strong style="color:rgba(255,255,255,0.7);">{{ $guruKonsul['nama'] }}</strong> &bull; Konsul: {{ $guruKonsul['telepon'] }}
        </span>
      </div>

    </div>
  </div>

  <script>
    function togglePw() {
      const pwInput = document.getElementById('password');
      const pwIcon  = document.getElementById('pw-icon');
      if (pwInput.type === 'password') {
        pwInput.type = 'text';
        pwIcon.className = 'fa-solid fa-eye-slash';
      } else {
        pwInput.type = 'password';
        pwIcon.className = 'fa-solid fa-eye';
      }
    }

    function handleSubmit(form) {
      const btn = document.getElementById('btn-submit');
      btn.classList.add('loading');
      btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i><span>Memverifikasi...</span>';
    }
  </script>

</body>
</html>
