<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tenant ? $tenant->nama_sekolah . ' — CBT SaaS' : 'CBT SaaS — Login' }}</title>
    <meta name="description" content="Login ke platform Computer Based Test (CBT) SaaS untuk sekolah modern.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:      #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light:#eff6ff;
            --primary-glow: rgba(37, 99, 235, 0.18);
            --accent:       #1e40af;
            --gold:         #d97706;
            --bg:           #f0f4f8;
            --surface:      #ffffff;
            --border:       #d1d5db;
            --border-focus: #2563eb;
            --text:         #111827;
            --text-2:       #374151;
            --text-3:       #6b7280;
            --error:        #dc2626;
            --error-bg:     #fef2f2;
            --success:      #16a34a;
            --sidebar-bg:   #1e3a5f;
            --sidebar-text: #e0ecff;
        }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* ── TOP BAR ── */
        .top-bar {
            background: var(--sidebar-bg);
            padding: 0 2rem;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            flex-shrink: 0;
        }
        .top-brand {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            text-decoration: none;
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: -0.01em;
        }
        .top-brand .brand-icon {
            width: 30px; height: 30px;
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; color: #fff;
            box-shadow: 0 2px 8px rgba(59,130,246,0.4);
            flex-shrink: 0;
        }
        .saas-badge {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: #1a1000;
            font-size: 0.55rem;
            font-weight: 800;
            padding: 1px 6px;
            border-radius: 12px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-left: 2px;
            vertical-align: super;
        }
        .top-bar-right {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.6);
        }
        .top-bar-right a {
            color: #93c5fd;
            text-decoration: none;
            font-weight: 600;
        }
        .top-bar-right a:hover { color: #ffffff; }

        /* ── MAIN LAYOUT ── */
        .page-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
        }

        /* ── WRAPPER ── */
        .login-wrapper {
            width: 100%;
            max-width: 920px;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow:
                0 0 0 1px rgba(0,0,0,0.08),
                0 20px 60px rgba(0,0,0,0.12),
                0 4px 16px rgba(37,99,235,0.08);
            background: #ffffff;
        }

        /* ── LEFT PANEL ── */
        .info-panel {
            flex: 1;
            background: linear-gradient(155deg, #1e3a5f 0%, #1e40af 55%, #1d4ed8 100%);
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .info-panel::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(255,255,255,0.07), transparent 65%);
            border-radius: 50%;
            pointer-events: none;
        }
        .info-panel::after {
            content: '';
            position: absolute;
            bottom: -50px; left: -30px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(255,255,255,0.05), transparent 65%);
            border-radius: 50%;
            pointer-events: none;
        }
        .panel-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 800;
            font-size: 1.125rem;
            color: #ffffff;
            letter-spacing: -0.02em;
            position: relative;
        }
        .panel-logo .logo-box {
            width: 42px; height: 42px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; color: #fff;
        }
        .panel-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem 0;
            position: relative;
        }
        .panel-body h2 {
            font-size: 1.875rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.25;
            letter-spacing: -0.03em;
            margin-bottom: 0.875rem;
        }
        .panel-body h2 .highlight {
            color: #93c5fd;
        }
        .panel-body p {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.65);
            line-height: 1.7;
            max-width: 270px;
            margin-bottom: 2rem;
        }
        .feature-chips {
            display: flex;
            flex-direction: column;
            gap: 0.625rem;
        }
        .feature-chip {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            font-size: 0.82rem;
            color: rgba(255,255,255,0.8);
        }
        .chip-dot {
            width: 20px; height: 20px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #93c5fd;
            font-size: 0.6rem;
            flex-shrink: 0;
        }
        .panel-footer {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.35);
            position: relative;
        }

        /* ── RIGHT FORM PANEL ── */
        .form-panel {
            width: 380px;
            background: #ffffff;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* ── TENANT BADGE ── */
        .tenant-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0.875rem;
        }
        .tenant-badge img {
            width: 16px; height: 16px;
            border-radius: 4px;
            object-fit: cover;
        }

        /* ── FORM HEADER ── */
        .form-header { margin-bottom: 1.75rem; }
        .form-header h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.02em;
            margin-bottom: 0.3rem;
        }
        .form-header p {
            font-size: 0.85rem;
            color: var(--text-3);
        }

        /* ── ALERT ── */
        .alert-error {
            background: var(--error-bg);
            border: 1px solid rgba(220,38,38,0.2);
            color: var(--error);
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 0.82rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            line-height: 1.5;
        }

        /* ── FORM INPUTS ── */
        .form-group { margin-bottom: 1rem; }
        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-2);
            margin-bottom: 0.4rem;
        }
        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon {
            position: absolute;
            left: 0.875rem;
            color: var(--text-3);
            font-size: 0.8rem;
            pointer-events: none;
        }
        .form-control {
            width: 100%;
            height: 44px;
            padding: 0 1rem 0 2.5rem;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            color: var(--text);
            background: #f9fafb;
            border: 1.5px solid var(--border);
            border-radius: 9px;
            outline: none;
            transition: all 0.18s ease;
        }
        .form-control::placeholder { color: #9ca3af; }
        .form-control:hover { border-color: #9ca3af; background: #ffffff; }
        .form-control:focus {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 3px var(--primary-glow);
        }
        .toggle-pw {
            position: absolute;
            right: 0.875rem;
            color: var(--text-3);
            cursor: pointer;
            font-size: 0.85rem;
            transition: color 0.15s;
        }
        .toggle-pw:hover { color: var(--primary); }

        /* ── REMEMBER ROW ── */
        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 0.5rem 0 1.25rem;
            font-size: 0.82rem;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-3);
            cursor: pointer;
            user-select: none;
        }
        .checkbox-label input[type="checkbox"] {
            accent-color: var(--primary);
            width: 15px; height: 15px; cursor: pointer;
        }

        /* ── SUBMIT BUTTON ── */
        .btn-submit {
            width: 100%;
            height: 46px;
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            border: none;
            border-radius: 9px;
            font-size: 0.9375rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            letter-spacing: 0.01em;
            box-shadow: 0 2px 8px rgba(37,99,235,0.3);
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%);
            box-shadow: 0 6px 20px rgba(37,99,235,0.35);
            transform: translateY(-1px);
        }
        .btn-submit:active { transform: translateY(0); box-shadow: none; }

        /* ── BOTTOM LINK ── */
        .form-bottom {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.82rem;
            color: var(--text-3);
            padding-top: 1.25rem;
            border-top: 1px solid #f3f4f6;
        }
        .form-bottom a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
        .form-bottom a:hover { color: var(--primary-dark); text-decoration: underline; }

        /* ── FOOTER ── */
        .page-footer {
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
            padding: 0.875rem 2rem;
            text-align: center;
            font-size: 0.75rem;
            color: var(--text-3);
            flex-shrink: 0;
        }

        /* Mobile */
        @media (max-width: 700px) {
            .info-panel { display: none; }
            .login-wrapper { max-width: 420px; }
            .form-panel { width: 100%; padding: 2.5rem 2rem; }
        }
    </style>
</head>
<body>

{{-- TOP BAR --}}
<header class="top-bar">
    <a href="{{ url('/') }}" class="top-brand">
        <div class="brand-icon"><i class="fa-solid fa-graduation-cap"></i></div>
        CBT <span class="saas-badge">SaaS</span>
    </a>
    <div class="top-bar-right">
        Belum punya akun? <a href="{{ route('register.school') }}">Daftarkan Sekolah &rarr;</a>
    </div>
</header>

{{-- MAIN --}}
<main class="page-main">
    <div class="login-wrapper">

        {{-- === LEFT INFO PANEL === --}}
        <div class="info-panel">
            <div class="panel-logo">
                <div class="logo-box"><i class="fa-solid fa-graduation-cap"></i></div>
                <span>CBT <span class="saas-badge">SaaS</span></span>
            </div>

            <div class="panel-body">
                @if($tenant && $tenant->logo)
                    <div style="margin-bottom: 1.5rem;">
                        <img src="{{ asset('storage/' . $tenant->logo) }}" alt="Logo {{ $tenant->nama_sekolah }}"
                             style="max-height: 64px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.2); padding: 6px; background: rgba(255,255,255,0.08);">
                    </div>
                @endif

                @if($tenant)
                    <h2>Portal Ujian<br><span class="highlight">{{ $tenant->nama_sekolah }}</span></h2>
                    <p>Sistem ujian online berbasis komputer (CBT) untuk guru dan siswa {{ $tenant->nama_sekolah }}.</p>
                @else
                    <h2>Platform CBT<br><span class="highlight">Sekolah Modern</span></h2>
                    <p>Sistem ujian berbasis komputer yang canggih, aman, dan mudah digunakan untuk semua jenjang pendidikan.</p>
                @endif

                <div class="feature-chips">
                    <div class="feature-chip">
                        <span class="chip-dot"><i class="fa-solid fa-check fa-xs"></i></span>
                        Multi-tenant untuk banyak sekolah
                    </div>
                    <div class="feature-chip">
                        <span class="chip-dot"><i class="fa-solid fa-check fa-xs"></i></span>
                        Analisis nilai ujian real-time
                    </div>
                    <div class="feature-chip">
                        <span class="chip-dot"><i class="fa-solid fa-check fa-xs"></i></span>
                        Bank soal & jadwal ujian terintegrasi
                    </div>
                    <div class="feature-chip">
                        <span class="chip-dot"><i class="fa-solid fa-check fa-xs"></i></span>
                        Anti-cheat & keamanan tinggi
                    </div>
                </div>
            </div>

            <div class="panel-footer">
                &copy; {{ date('Y') }} CBT SaaS &mdash; Untuk Pendidikan Indonesia
            </div>
        </div>

        {{-- === RIGHT FORM PANEL === --}}
        <div class="form-panel">
            <div class="form-header">
                @if($tenant)
                    <div class="tenant-badge">
                        @if($tenant->logo)
                            <img src="{{ asset('storage/' . $tenant->logo) }}" alt="">
                        @else
                            <i class="fa-solid fa-school"></i>
                        @endif
                        {{ $tenant->nama_sekolah }}
                    </div>
                    <h2>Selamat Datang 👋</h2>
                    <p>Masuk ke sistem CBT sekolah Anda</p>
                @else
                    <h2>Masuk ke CBT <span style="color:var(--primary);">SaaS</span></h2>
                    <p>Masukkan email dan password akun Anda</p>
                @endif
            </div>

            @if($errors->any())
                <div class="alert-error">
                    <i class="fa-solid fa-circle-exclamation" style="margin-top:2px;flex-shrink:0;"></i>
                    <div>
                        @foreach($errors->all() as $e)
                            <div>{{ $e }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ $tenant ? route('school.login', ['slug' => $tenant->slug]) : route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-envelope input-icon"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="nama@sekolah.sch.id"
                            required
                            autofocus
                            value="{{ old('email') }}"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="••••••••"
                            required
                        >
                        <span class="toggle-pw" onclick="togglePw()" id="toggle-pw-icon">
                            <i class="fa-solid fa-eye" id="pw-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="form-footer">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember"> Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn-submit" id="btn-login">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Masuk ke CBT SaaS
                </button>
            </form>

            @if(!$tenant)
                <div class="form-bottom">
                    Sekolah belum terdaftar? <a href="{{ route('register.school') }}">Daftarkan sekarang &rarr;</a>
                </div>
            @endif
        </div>

    </div>
</main>

{{-- PAGE FOOTER --}}
<footer class="page-footer">
    Computer Based Test (CBT) &mdash; Platform Ujian Online SaaS Multi-Tenant &copy; {{ date('Y') }}
</footer>

<script>
function togglePw() {
    const input = document.getElementById('password');
    const icon = document.getElementById('pw-eye');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fa-solid fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fa-solid fa-eye';
    }
}
</script>

</body>
</html>
