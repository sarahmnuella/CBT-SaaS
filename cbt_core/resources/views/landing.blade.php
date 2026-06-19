<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CBT SaaS — Platform Ujian Online Multi-Tenant</title>
    <meta name="description" content="Platform CBT online multi-tenant untuk sekolah dan instansi pendidikan Indonesia. Ujian digital yang aman, cepat, dan adil.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:           #f0f4f8; /* Soft light greyish blue background */
            --bg-2:         #ffffff; /* Pure white background for list hover */
            --bg-3:         #ffffff; /* Card background: Pure white */
            --bg-4:         #f3f4f6; /* Accent background: Light grey */
            --border:       #e5e7eb; /* Soft border color */
            --border-2:     #d1d5db; /* Stronger border color */
            --text:         #111827; /* Dark slate text */
            --text-2:       #374151; /* Medium slate text */
            --text-3:       #6b7280; /* Muted grey text */
            --accent:       #2563eb; /* Primary theme color (Blue) */
            --accent-2:     #1d4ed8; /* Darker primary color */
            --accent-glow:  rgba(37, 99, 235, 0.15);
            --gold:         #d97706;
            --success:      #16a34a;
            --radius:       9px;
            --radius-lg:    12px;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            line-height: 1.6;
        }

        /* ─── NAVBAR ─── */
        .navbar {
            position: sticky; top: 0; z-index: 200;
            height: 56px;
            border-bottom: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.88); /* Translucent White */
            backdrop-filter: blur(16px) saturate(1.8);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2rem;
        }
        .brand {
            display: flex; align-items: center; gap: 0.5rem;
            text-decoration: none; font-weight: 700; font-size: 0.9375rem; color: var(--text);
        }
        .brand-icon {
            width: 28px; height: 28px; background: linear-gradient(135deg, var(--accent), #3b82f6); border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; color: white;
            box-shadow: 0 2px 10px var(--accent-glow);
        }
        .nav-links { display: flex; align-items: center; gap: 0.25rem; }
        .nav-link {
            padding: 0.35rem 0.75rem; border-radius: 6px;
            color: var(--text-2); text-decoration: none;
            font-size: 0.875rem; font-weight: 500; transition: all 0.15s;
        }
        .nav-link:hover { background: var(--bg-4); color: var(--text); }

        .btn {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.45rem 0.875rem; border-radius: var(--radius);
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
        }
        .btn-ghost {
            background: transparent; color: var(--text-2); border-color: var(--border);
        }
        .btn-ghost:hover { background: var(--bg-4); color: var(--text); border-color: var(--border-2); }
        .btn-lg { padding: 0.65rem 1.375rem; font-size: 0.9375rem; border-radius: 9px; }
        .btn-outline {
            background: #ffffff; color: var(--text); border-color: var(--border-2);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .btn-outline:hover { background: var(--bg-4); }

        /* ─── HERO ─── */
        .hero {
            text-align: center;
            padding: 6rem 1.5rem 4rem;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 50% -10%, rgba(37, 99, 235, 0.08) 0%, transparent 60%);
            pointer-events: none;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8125rem; font-weight: 600;
            margin-bottom: 1.75rem;
        }
        .hero-badge i { font-size: 0.6875rem; }

        .hero-title {
            font-size: clamp(2.25rem, 5vw, 3.75rem);
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1.1;
            color: var(--text);
            margin-bottom: 1.5rem;
            max-width: 760px;
            margin-left: auto; margin-right: auto;
        }
        .hero-title span {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 50%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-sub {
            font-size: 1.125rem;
            color: var(--text-2);
            max-width: 580px;
            margin: 0 auto 2.5rem;
            line-height: 1.7;
        }

        .hero-actions { display: flex; justify-content: center; align-items: center; gap: 0.75rem; flex-wrap: wrap; }

        .hero-meta {
            margin-top: 1.5rem;
            font-size: 0.8125rem; color: var(--text-3);
            display: flex; justify-content: center; align-items: center; gap: 0.4rem;
        }
        .hero-meta i { color: var(--success); font-size: 0.75rem; }

        /* ─── DIVIDER LINE ─── */
        .section-divider {
            border: none; border-top: 1px solid var(--border);
            margin: 0;
        }

        /* ─── FEATURES STRIP ─── */
        .features-strip {
            display: flex; justify-content: center; align-items: center;
            gap: 2rem; flex-wrap: wrap;
            padding: 2rem 2rem;
            border-bottom: 1px solid var(--border);
            background: #ffffff;
        }
        .feature-item {
            display: flex; align-items: center; gap: 0.5rem;
            font-size: 0.875rem; color: var(--text-2); font-weight: 500;
        }
        .feature-item i { color: var(--accent); width: 14px; text-align: center; }

        /* ─── SECTIONS ─── */
        .section { padding: 5rem 2rem; max-width: 1100px; margin: 0 auto; }

        .section-header {
            margin-bottom: 3rem;
            text-align: center;
        }
        .section-label {
            display: inline-block;
            font-size: 0.75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.08em;
            color: #2563eb; margin-bottom: 0.75rem;
        }
        .section-title {
            font-size: clamp(1.5rem, 3vw, 2.25rem);
            font-weight: 800; letter-spacing: -0.03em;
            color: var(--text); margin-bottom: 0.75rem;
        }
        .section-desc { font-size: 1rem; color: var(--text-3); max-width: 520px; margin: 0 auto; }

        /* ─── FEATURE CARDS ─── */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1px;
            background: var(--border);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        }
        .feature-card {
            background: var(--bg-3);
            padding: 2rem;
            transition: background 0.15s;
        }
        .feature-card:hover { background: #f9fafb; }
        .feature-icon {
            width: 36px; height: 36px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.875rem; color: #2563eb;
            margin-bottom: 1rem;
        }
        .feature-card h3 {
            font-size: 0.9375rem; font-weight: 700;
            color: var(--text); margin-bottom: 0.5rem;
            letter-spacing: -0.01em;
        }
        .feature-card p { font-size: 0.875rem; color: var(--text-2); line-height: 1.65; }

        /* ─── PRICING ─── */
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1rem;
        }
        .price-card {
            background: var(--bg-3);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2rem;
            display: flex; flex-direction: column;
            transition: all 0.15s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }
        .price-card:hover { border-color: var(--border-2); transform: translateY(-2px); }
        .price-card.featured {
            border-color: rgba(37,99,235,0.4);
            background: linear-gradient(135deg, #eff6ff 0%, rgba(219,234,254,0.5) 100%);
            position: relative;
            box-shadow: 0 8px 30px rgba(37,99,235,0.08);
        }
        .featured-tag {
            position: absolute; top: -1px; right: 1.5rem;
            background: var(--accent);
            color: white; font-size: 0.6875rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.06em;
            padding: 0.25rem 0.625rem; border-radius: 0 0 6px 6px;
        }
        .price-tier { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--text-3); margin-bottom: 0.5rem; }
        .price-name { font-size: 1.125rem; font-weight: 700; color: var(--text); margin-bottom: 0.25rem; }
        .price-desc { font-size: 0.8125rem; color: var(--text-3); margin-bottom: 1.5rem; }
        .price-amount {
            font-size: 2.5rem; font-weight: 800; letter-spacing: -0.04em;
            color: var(--text); margin-bottom: 0.25rem;
        }
        .price-amount span { font-size: 1rem; font-weight: 400; color: var(--text-3); }
        .price-period { font-size: 0.8125rem; color: var(--text-3); margin-bottom: 1.75rem; }
        .price-divider { border: none; border-top: 1px solid var(--border); margin: 1.25rem 0; }
        .price-features { list-style: none; display: flex; flex-direction: column; gap: 0.625rem; flex: 1; margin-bottom: 1.75rem; }
        .price-features li {
            display: flex; align-items: center; gap: 0.625rem;
            font-size: 0.8125rem; color: var(--text-2);
        }
        .price-features li i { color: var(--success); font-size: 0.75rem; width: 12px; flex-shrink: 0; }
        .price-features li.dim i { color: var(--text-3); }
        .price-features li.dim { color: var(--text-3); }

        /* ─── CTA ─── */
        .cta-section {
            border-top: 1px solid var(--border);
            padding: 5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            background: #ffffff;
        }
        .cta-section::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 70% 80% at 50% 100%, rgba(37, 99, 235, 0.05) 0%, transparent 60%);
            pointer-events: none;
        }
        .cta-title {
            font-size: clamp(1.5rem, 3vw, 2.5rem);
            font-weight: 800; letter-spacing: -0.03em;
            color: var(--text); margin-bottom: 1rem; position: relative;
        }
        .cta-sub { font-size: 1rem; color: var(--text-2); max-width: 480px; margin: 0 auto 2rem; position: relative; }

        /* ─── FOOTER ─── */
        footer {
            border-top: 1px solid var(--border);
            padding: 2rem;
            background: #ffffff;
            display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;
        }
        footer p { font-size: 0.8125rem; color: var(--text-3); }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 640px) {
            .navbar { padding: 0 1.25rem; }
            .hero { padding: 4rem 1.25rem 3rem; }
            .features-strip { gap: 1rem; }
            .section { padding: 3.5rem 1.25rem; }
            footer { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="{{ url('/') }}" class="brand">
        <div class="brand-icon"><i class="fa-solid fa-graduation-cap"></i></div>
        CBT <span style="background:linear-gradient(135deg,#d97706,#f59e0b);color:#1a1000;font-size:0.55rem;font-weight:800;padding:1px 6px;border-radius:12px;letter-spacing:0.08em;text-transform:uppercase;margin-left:3px;">SaaS</span>
    </a>
    <div class="nav-links">
        <a href="#fitur" class="nav-link">Fitur</a>
        <a href="#harga" class="nav-link">Harga</a>
        <a href="{{ route('login') }}" class="nav-link">Masuk</a>
        <a href="{{ route('register.school') }}" class="btn btn-primary" style="margin-left:0.25rem;">
            Coba Gratis
        </a>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-badge">
        <i class="fa-solid fa-circle-check"></i> Baru · Multi-Tenant CBT Platform v2.0
    </div>
    <h1 class="hero-title">
        Ujian Online yang <span>Aman, Adil</span><br>dan Profesional
    </h1>
    <p class="hero-sub">
        Platform CBT berbasis cloud dengan isolasi data penuh per sekolah,
        engine anti-cheat canggih, dan dasbor real-time yang mudah digunakan.
    </p>
    <div class="hero-actions">
        <a href="{{ route('register.school') }}" class="btn btn-primary btn-lg">
            Mulai Trial 14 Hari Gratis <i class="fa-solid fa-arrow-right"></i>
        </a>
        <a href="{{ route('login') }}" class="btn btn-outline btn-lg">
            Masuk ke Akun
        </a>
    </div>
    <p class="hero-meta">
        <i class="fa-solid fa-circle-check"></i>
        Tidak perlu kartu kredit &nbsp;·&nbsp;
        <i class="fa-solid fa-circle-check"></i>
        Setup kurang dari 2 menit &nbsp;·&nbsp;
        <i class="fa-solid fa-circle-check"></i>
        Data terisolasi penuh
    </p>
</section>

<hr class="section-divider">

<!-- FEATURES STRIP -->
<div class="features-strip">
    <div class="feature-item"><i class="fa-solid fa-shield-halved"></i> Anti-Cheat Engine</div>
    <div class="feature-item"><i class="fa-solid fa-bolt"></i> Auto-Save Jawaban</div>
    <div class="feature-item"><i class="fa-solid fa-users"></i> Multi-Tenant Terisolasi</div>
    <div class="feature-item"><i class="fa-solid fa-chart-pie"></i> Rekap Nilai Otomatis</div>
    <div class="feature-item"><i class="fa-solid fa-lock"></i> Data Aman & Terenkripsi</div>
    <div class="feature-item"><i class="fa-solid fa-mobile-screen"></i> Responsif di Semua Device</div>
</div>

<!-- FEATURES SECTION -->
<section class="section" id="fitur">
    <div class="section-header">
        <span class="section-label">Fitur Unggulan</span>
        <h2 class="section-title">Semua yang Dibutuhkan<br>untuk CBT Modern</h2>
        <p class="section-desc">Dari pembuatan soal hingga rekap nilai — semua dalam satu platform yang terintegrasi.</p>
    </div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-building-columns"></i></div>
            <h3>Multi-Sekolah Terisolasi</h3>
            <p>Setiap sekolah mendapatkan portal login, URL, dan database yang sepenuhnya terisolasi. Data Sekolah A tidak dapat dilihat oleh Sekolah B.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
            <h3>Sistem Anti-Cheat Canggih</h3>
            <p>Deteksi otomatis jika siswa berpindah tab, meminimalkan browser, atau beralih ke aplikasi lain. Ujian langsung terkunci dan disubmit secara otomatis.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-floppy-disk"></i></div>
            <h3>Auto-Save Jawaban</h3>
            <p>Setiap pilihan jawaban siswa langsung tersimpan ke server secara real-time via AJAX. Tidak ada jawaban yang hilang jika koneksi terputus.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-database"></i></div>
            <h3>Bank Soal Lengkap</h3>
            <p>Buat soal Pilihan Ganda maupun Essay dengan editor yang mudah digunakan. Soal dapat diacak secara otomatis tiap siswa.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-chart-bar"></i></div>
            <h3>Rekap Nilai Real-time</h3>
            <p>Guru dan Admin dapat memantau progres ujian secara langsung. Rekap nilai lengkap tersedia segera setelah ujian selesai.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-sliders"></i></div>
            <h3>Manajemen Kuota Fleksibel</h3>
            <p>Setiap sekolah mendapatkan batasan jumlah guru dan siswa sesuai paket berlangganan. Upgrade kapan saja sesuai kebutuhan.</p>
        </div>
    </div>
</section>

<!-- PRICING -->
<section class="section" id="harga" style="border-top: 1px solid var(--border); padding-top: 5rem;">
    <div class="section-header">
        <span class="section-label">Paket Berlangganan</span>
        <h2 class="section-title">Harga Sederhana,<br>Tanpa Biaya Tersembunyi</h2>
        <p class="section-desc">Mulai gratis, upgrade ketika butuh lebih. Tidak ada setup fee, tidak ada kontrak jangka panjang.</p>
    </div>
    <div class="pricing-grid">
        <!-- FREE -->
        <div class="price-card">
            <p class="price-tier">Starter</p>
            <h3 class="price-name">Uji Coba</h3>
            <p class="price-desc">Untuk mengenal platform</p>
            <div class="price-amount">Rp 0</div>
            <p class="price-period">Selamanya</p>
            <hr class="price-divider">
            <ul class="price-features">
                <li><i class="fa-solid fa-check"></i> Maksimal 15 Siswa</li>
                <li><i class="fa-solid fa-check"></i> Maksimal 2 Guru</li>
                <li><i class="fa-solid fa-check"></i> Bank Soal Terbatas</li>
                <li><i class="fa-solid fa-check"></i> CBT Engine Dasar</li>
                <li class="dim"><i class="fa-solid fa-xmark"></i> Anti-Cheat Lanjutan</li>
                <li class="dim"><i class="fa-solid fa-xmark"></i> Rekap Excel</li>
            </ul>
            <a href="{{ route('register.school') }}" class="btn btn-outline" style="justify-content:center;">
                Mulai Gratis
            </a>
        </div>

        <!-- TRIAL / MOST POPULAR -->
        <div class="price-card featured">
            <div class="featured-tag">Terpopuler</div>
            <p class="price-tier">Growth</p>
            <h3 class="price-name">Trial Sekolah</h3>
            <p class="price-desc">Akses penuh 14 hari</p>
            <div class="price-amount">Gratis <span>/ 14 Hari</span></div>
            <p class="price-period">Tanpa kartu kredit</p>
            <hr class="price-divider">
            <ul class="price-features">
                <li><i class="fa-solid fa-check"></i> Maksimal 50 Siswa</li>
                <li><i class="fa-solid fa-check"></i> Maksimal 10 Guru</li>
                <li><i class="fa-solid fa-check"></i> Bank Soal Tidak Terbatas</li>
                <li><i class="fa-solid fa-check"></i> Anti-Cheat Engine Penuh</li>
                <li><i class="fa-solid fa-check"></i> Auto-Save Jawaban</li>
                <li><i class="fa-solid fa-check"></i> Rekap Nilai & Export</li>
            </ul>
            <a href="{{ route('register.school') }}" class="btn btn-primary" style="justify-content:center;">
                Mulai Trial Sekarang <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <!-- PREMIUM -->
        <div class="price-card">
            <p class="price-tier">Enterprise</p>
            <h3 class="price-name">Premium Sekolah</h3>
            <p class="price-desc">Untuk operasional penuh</p>
            <div class="price-amount">Custom</div>
            <p class="price-period">Hubungi tim kami</p>
            <hr class="price-divider">
            <ul class="price-features">
                <li><i class="fa-solid fa-check"></i> Siswa & Guru Unlimited</li>
                <li><i class="fa-solid fa-check"></i> Custom Domain / Subdomain</li>
                <li><i class="fa-solid fa-check"></i> Backup Database Berkala</li>
                <li><i class="fa-solid fa-check"></i> Semua Fitur Premium</li>
                <li><i class="fa-solid fa-check"></i> Prioritas Dukungan 24/7</li>
                <li><i class="fa-solid fa-check"></i> SLA 99.9% Uptime</li>
            </ul>
            <a href="https://wa.me/6281265893453?text=Halo%20Tim%20Sales%20CBT%20SaaS,%20saya%20tertarik%20dengan%20paket%20Premium%20Sekolah" target="_blank" class="btn btn-outline" style="justify-content:center;">
                <i class="fa-brands fa-whatsapp"></i> Hubungi Tim Sales
            </a>
        </div>
    </div>
</section>

<!-- CTA -->
<div class="cta-section">
    <h2 class="cta-title">Siap Menggelar Ujian yang<br>Lebih Adil dan Modern?</h2>
    <p class="cta-sub">Bergabung bersama sekolah-sekolah yang sudah menggunakan CBT SaaS. Mulai dalam 2 menit.</p>
    <div style="display:flex; justify-content:center; gap:0.75rem; position:relative; flex-wrap:wrap;">
        <a href="{{ route('register.school') }}" class="btn btn-primary btn-lg">
            Daftarkan Sekolah Sekarang <i class="fa-solid fa-arrow-right"></i>
        </a>
        <a href="{{ route('login') }}" class="btn btn-outline btn-lg">
            Sudah Punya Akun
        </a>
    </div>
</div>

<footer>
    <p>© {{ date('Y') }} CBT SaaS — Platform Ujian Online Multi-Tenant.</p>
    <p>Dibuat dengan <i class="fa-solid fa-heart" style="color:#ef4444; font-size:0.75rem;"></i> untuk dunia pendidikan Indonesia.</p>
</footer>

</body>
</html>
