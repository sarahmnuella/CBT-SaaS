<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftarkan Sekolah — CBT SaaS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary:      #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light:#eff6ff;
            --primary-glow: rgba(37, 99, 235, 0.18);
            --gold:         #d97706;
            --bg:           #f0f4f8;
            --surface:      #ffffff;
            --border:       #d1d5db;
            --border-2:     #9ca3af;
            --text:         #111827;
            --text-2:       #374151;
            --text-3:       #6b7280;
            --error:        #dc2626;
            --error-bg:     #fef2f2;
            --success:      #16a34a;
            --sidebar-bg:   #1e3a5f;
            --radius:       9px;
        }

        html, body { min-height: 100vh; }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
        }

        /* ── TOP BAR ── */
        .topbar {
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            background: var(--sidebar-bg);
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            flex-shrink: 0;
        }
        .brand {
            display: flex; align-items: center; gap: 0.5rem;
            text-decoration: none; font-weight: 700;
            font-size: 0.9375rem; color: #ffffff;
        }
        .brand-icon {
            width: 28px; height: 28px;
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; color: white;
            box-shadow: 0 2px 8px rgba(59,130,246,0.4);
        }
        .saas-tag {
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: #1a1000; font-size: 0.55rem; font-weight: 800;
            padding: 1px 6px; border-radius: 12px;
            letter-spacing: 0.08em; text-transform: uppercase; margin-left: 3px;
        }
        .topbar-link { font-size: 0.8125rem; color: rgba(255,255,255,0.6); text-decoration: none; }
        .topbar-link strong { color: #93c5fd; }
        .topbar-link:hover strong { color: #ffffff; }

        /* ── MAIN CONTENT ── */
        .page {
            flex: 1;
            display: flex;
            justify-content: center;
            padding: 2.5rem 1.5rem 4rem;
        }
        .page-wrap { width: 100%; max-width: 540px; }

        /* ── PAGE HEADER ── */
        .page-header { margin-bottom: 2rem; text-align: center; }
        .step-badge {
            display: inline-flex; align-items: center; gap: 0.375rem;
            background: #eff6ff; border: 1px solid #bfdbfe;
            color: #1d4ed8; padding: 0.3rem 0.75rem; border-radius: 20px;
            font-size: 0.75rem; font-weight: 600; margin-bottom: 1rem;
        }
        .page-header h1 {
            font-size: 1.75rem; font-weight: 800;
            letter-spacing: -0.03em; margin-bottom: 0.5rem;
            color: var(--text);
        }
        .page-header p { font-size: 0.875rem; color: var(--text-3); }

        /* ── FORM CARD ── */
        .form-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06), 0 1px 4px rgba(0,0,0,0.04);
        }
        .form-card-body { padding: 2rem; }

        /* ── SECTION INSIDE FORM ── */
        .form-section { margin-bottom: 1.75rem; }
        .form-section-title {
            font-size: 0.72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.07em;
            color: var(--text-3); margin-bottom: 1rem;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .form-section-title i { color: var(--primary); font-size: 0.75rem; }
        .form-section-title::after { content: ''; flex: 1; border-top: 1px solid #f3f4f6; }

        /* ── INPUTS ── */
        .form-group { margin-bottom: 0.875rem; }
        .form-label {
            display: block; font-size: 0.8125rem; font-weight: 600;
            color: var(--text-2); margin-bottom: 0.35rem;
        }
        .form-label .required { color: var(--error); margin-left: 2px; }
        .form-hint { font-size: 0.75rem; color: var(--text-3); margin-top: 0.3rem; }

        .form-control {
            width: 100%; background: #f9fafb; border: 1.5px solid var(--border);
            color: var(--text); padding: 0.5625rem 0.75rem; border-radius: var(--radius);
            font-size: 0.875rem; font-family: inherit; transition: all 0.15s;
        }
        .form-control::placeholder { color: #9ca3af; }
        .form-control:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 3px var(--primary-glow); background: #ffffff; }
        .form-control:hover:not(:focus) { border-color: var(--border-2); background: #ffffff; }

        /* ── SLUG INPUT ── */
        .slug-group { display: flex; }
        .slug-prefix {
            display: flex; align-items: center;
            background: #f3f4f6; border: 1.5px solid var(--border);
            border-right: none; padding: 0 0.75rem;
            border-radius: var(--radius) 0 0 var(--radius);
            font-size: 0.75rem; color: var(--text-3);
            font-family: 'DM Mono', monospace;
            white-space: nowrap; flex-shrink: 0;
        }
        .slug-group .form-control {
            border-radius: 0 var(--radius) var(--radius) 0;
            font-family: 'DM Mono', monospace;
        }

        /* ── TWO-COL GRID ── */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.875rem; }
        @media (max-width: 480px) { .form-row { grid-template-columns: 1fr; } }

        /* ── INPUT WITH ICON ── */
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 0.75rem; top: 50%;
            transform: translateY(-50%); font-size: 0.8125rem;
            color: var(--text-3); pointer-events: none;
        }
        .input-wrap .form-control { padding-left: 2.25rem; }

        /* ── PASSWORD STRENGTH ── */
        .strength-bar { display: flex; gap: 4px; margin-top: 0.4rem; }
        .strength-bar span {
            flex: 1; height: 3px; background: #e5e7eb; border-radius: 2px;
            transition: background 0.3s;
        }
        .strength-bar[data-strength="1"] span:nth-child(1) { background: #dc2626; }
        .strength-bar[data-strength="2"] span:nth-child(-n+2) { background: #d97706; }
        .strength-bar[data-strength="3"] span:nth-child(-n+3) { background: #2563eb; }
        .strength-bar[data-strength="4"] span { background: #16a34a; }

        /* ── SUBMIT AREA ── */
        .form-submit {
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            padding: 1.25rem 2rem;
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
            flex-wrap: wrap;
        }
        .submit-note { font-size: 0.75rem; color: var(--text-3); display: flex; align-items: center; gap: 0.375rem; }
        .submit-note i { color: var(--success); }

        .btn {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.5625rem 1.25rem; border-radius: var(--radius);
            font-size: 0.875rem; font-weight: 600; cursor: pointer;
            text-decoration: none; border: 1px solid transparent;
            transition: all 0.15s; font-family: inherit;
        }
        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            box-shadow: 0 2px 8px rgba(37,99,235,0.25);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e3a8a);
            box-shadow: 0 4px 16px rgba(37,99,235,0.35);
            transform: translateY(-1px);
        }
        .btn-primary:active { transform: scale(0.98); }
        .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; }

        /* ── ALERT ── */
        .alert-error {
            background: var(--error-bg); border: 1px solid rgba(220,38,38,0.2);
            color: var(--error); padding: 0.875rem 1rem; border-radius: var(--radius);
            font-size: 0.8125rem; margin-bottom: 1.25rem;
            display: flex; align-items: flex-start; gap: 0.5rem;
        }
        .alert-error i { flex-shrink: 0; margin-top: 1px; }

        /* ── BOTTOM LINK ── */
        .page-footer { text-align: center; margin-top: 1.25rem; font-size: 0.8125rem; color: var(--text-3); }
        .page-footer a { color: var(--primary); text-decoration: none; font-weight: 600; }
        .page-footer a:hover { color: var(--primary-dark); text-decoration: underline; }

        /* ── SITE FOOTER ── */
        .site-footer {
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
            padding: 0.875rem 2rem;
            text-align: center;
            font-size: 0.75rem;
            color: var(--text-3);
            flex-shrink: 0;
        }
    </style>
</head>
<body>

<div class="topbar">
    <a href="{{ url('/') }}" class="brand">
        <div class="brand-icon"><i class="fa-solid fa-graduation-cap"></i></div>
        CBT <span class="saas-tag">SaaS</span>
    </a>
    <a href="{{ route('login') }}" class="topbar-link">
        Sudah punya akun? <strong>Masuk ke CBT SaaS &rarr;</strong>
    </a>
</div>

<div class="page">
    <div class="page-wrap">
        <div class="page-header">
            <div class="step-badge">
                <i class="fa-solid fa-rocket"></i> Trial Gratis &middot; 14 Hari &middot; Tanpa Kartu Kredit
            </div>
            <h1>Daftarkan Sekolah Anda</h1>
            <p>Setup selesai dalam 2 menit. Akses penuh semua fitur langsung tersedia.</p>
        </div>

        @if($errors->any())
            <div class="alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
            </div>
        @endif

        <div class="form-card">
            <form action="{{ route('register.school') }}" method="POST">
                @csrf
                <div class="form-card-body">

                    {{-- SECTION: Identitas Sekolah --}}
                    <div class="form-section">
                        <div class="form-section-title"><i class="fa-solid fa-school"></i> Identitas Sekolah</div>

                        <div class="form-group">
                            <label class="form-label">Nama Sekolah / Instansi <span class="required">*</span></label>
                            <div class="input-wrap">
                                <i class="fa-solid fa-school input-icon"></i>
                                <input type="text" name="nama_sekolah" class="form-control"
                                    placeholder="Contoh: SMA Negeri 1 Jakarta"
                                    required value="{{ old('nama_sekolah') }}"
                                    id="input-sekolah">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Slug URL Portal Login <span class="required">*</span></label>
                            <div class="slug-group">
                                <span class="slug-prefix">{{ url('/') }}/s/</span>
                                <input type="text" name="slug" class="form-control"
                                    placeholder="sman1jakarta"
                                    pattern="[a-z0-9\-_]+" required
                                    value="{{ old('slug') }}" id="input-slug">
                            </div>
                            <p class="form-hint"><i class="fa-solid fa-circle-info" style="margin-right:3px;color:#2563eb;"></i> Hanya huruf kecil, angka, (-), dan (_). Ini link login sekolah Anda.</p>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nomor Telepon / WhatsApp</label>
                            <div class="input-wrap">
                                <i class="fa-solid fa-phone input-icon"></i>
                                <input type="text" name="phone" class="form-control"
                                    placeholder="08123456789"
                                    value="{{ old('phone') }}">
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: Akun Admin --}}
                    <div class="form-section">
                        <div class="form-section-title"><i class="fa-solid fa-user-shield"></i> Akun Administrator Sekolah</div>

                        <div class="form-group">
                            <label class="form-label">Alamat Email Resmi <span class="required">*</span></label>
                            <div class="input-wrap">
                                <i class="fa-solid fa-envelope input-icon"></i>
                                <input type="email" name="email" class="form-control"
                                    placeholder="admin@sekolah.sch.id"
                                    required value="{{ old('email') }}">
                            </div>
                            <p class="form-hint">Email ini digunakan untuk login sebagai Admin Sekolah.</p>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Password <span class="required">*</span></label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Min. 8 karakter" required minlength="8"
                                    id="input-password">
                                <div class="strength-bar" id="strength-bar">
                                    <span></span><span></span><span></span><span></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Konfirmasi Password <span class="required">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Ulangi password" required>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-submit">
                    <p class="submit-note">
                        <i class="fa-solid fa-circle-check"></i>
                        Trial 14 hari &middot; Tanpa kartu kredit
                    </p>
                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        <i class="fa-solid fa-graduation-cap"></i>
                        Daftarkan Sekolah ke CBT SaaS <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>

        <p class="page-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk ke CBT SaaS &rarr;</a>
        </p>
    </div>
</div>

<footer class="site-footer">
    Computer Based Test (CBT) &mdash; Platform Ujian Online SaaS Multi-Tenant &copy; {{ date('Y') }}
</footer>

<script>
// Auto-generate slug from school name
const schoolInput = document.getElementById('input-sekolah');
const slugInput = document.getElementById('input-slug');
let slugEdited = slugInput.value.length > 0;

schoolInput.addEventListener('input', () => {
    if (slugEdited) return;
    const slug = schoolInput.value
        .toLowerCase()
        .replace(/\s+/g, '')
        .replace(/[^a-z0-9\-_]/g, '')
        .substring(0, 30);
    slugInput.value = slug;
});

slugInput.addEventListener('input', () => {
    slugEdited = true;
    slugInput.value = slugInput.value.toLowerCase().replace(/[^a-z0-9\-_]/g, '');
});

// Password strength indicator
const pwInput = document.getElementById('input-password');
const strengthBar = document.getElementById('strength-bar');

pwInput.addEventListener('input', () => {
    const v = pwInput.value;
    let strength = 0;
    if (v.length >= 8) strength++;
    if (/[A-Z]/.test(v) || /[a-z]/.test(v)) strength++;
    if (/\d/.test(v)) strength++;
    if (/[^A-Za-z0-9]/.test(v)) strength++;
    strengthBar.setAttribute('data-strength', v.length > 0 ? Math.max(1, strength) : 0);
});
</script>
</body>
</html>
