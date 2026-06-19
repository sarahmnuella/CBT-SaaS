@extends('layouts.app')

@section('title', 'Dashboard — ' . $tenant->nama_sekolah)

@section('head')
<style>
    /* ── Welcome Banner ── */
    .welcome-banner {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #1e1b4b 100%);
        border: 1px solid rgba(99,102,241,0.3);
        border-radius: 16px;
        padding: 2rem 2.5rem;
        margin-bottom: 1.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(99,102,241,0.25), transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -40px; left: 30%;
        width: 150px; height: 150px;
        background: radial-gradient(circle, rgba(139,92,246,0.15), transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .welcome-text h1 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.02em;
        margin-bottom: 0.35rem;
    }
    .welcome-text p {
        color: rgba(255,255,255,0.7);
        font-size: 0.9rem;
    }
    .welcome-badge-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-shrink: 0;
    }
    .welcome-icon {
        width: 56px; height: 56px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        color: #c7d2fe;
    }

    /* ── Stat Cards Premium ── */
    .stats-grid-new {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(175px, 1fr));
        gap: 1rem;
        margin-bottom: 1.75rem;
    }
    .stat-card-new {
        border-radius: 14px;
        padding: 1.4rem 1.5rem;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        display: block;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid rgba(255,255,255,0.08);
    }
    .stat-card-new:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.25);
    }
    .stat-card-new::before {
        content: '';
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        background: inherit;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .stat-card-new .sc-icon {
        width: 44px; height: 44px;
        background: rgba(255,255,255,0.15);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
        color: #fff;
        margin-bottom: 1rem;
    }
    .stat-card-new .sc-value {
        font-size: 2.25rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1;
        letter-spacing: -0.03em;
        margin-bottom: 0.3rem;
    }
    .stat-card-new .sc-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: rgba(255,255,255,0.75);
        letter-spacing: 0.01em;
    }
    .stat-card-new .sc-footer {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        margin-top: 0.75rem;
        font-size: 0.75rem;
        color: rgba(255,255,255,0.6);
    }
    /* Color themes */
    .sc-indigo  { background: linear-gradient(135deg, #4f46e5, #6366f1); }
    .sc-emerald { background: linear-gradient(135deg, #059669, #10b981); }
    .sc-amber   { background: linear-gradient(135deg, #d97706, #f59e0b); }
    .sc-rose    { background: linear-gradient(135deg, #dc2626, #f87171); }
    .sc-violet  { background: linear-gradient(135deg, #7c3aed, #a78bfa); }

    /* ── Info Card Grid ── */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 640px) {
        .info-grid { grid-template-columns: 1fr; }
        .welcome-banner { flex-direction: column; align-items: flex-start; }
        .stats-grid-new { grid-template-columns: 1fr 1fr; }
    }

    .info-card {
        background: var(--bg-3);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        transition: border-color 0.15s;
    }
    .info-card:hover { border-color: var(--border-2); }
    .info-card .ic-icon {
        width: 38px; height: 38px;
        background: rgba(99,102,241,0.1);
        border: 1px solid rgba(99,102,241,0.2);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: #818cf8;
        font-size: 0.95rem;
        flex-shrink: 0;
    }
    .info-card .ic-body {}
    .info-card .ic-label {
        font-size: 0.72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-3);
        margin-bottom: 0.25rem;
    }
    .info-card .ic-value {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--text);
    }

    /* ── Quick Links ── */
    .quick-links {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 0.75rem;
    }
    .quick-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 1.25rem 1rem;
        background: var(--bg-3);
        border: 1px solid var(--border);
        border-radius: 12px;
        text-decoration: none;
        color: var(--text-2);
        font-size: 0.82rem;
        font-weight: 600;
        transition: all 0.15s;
        text-align: center;
    }
    .quick-link:hover {
        border-color: var(--accent);
        color: var(--accent);
        background: rgba(96,92,168,0.05);
        transform: translateY(-2px);
    }
    .quick-link i {
        font-size: 1.3rem;
        color: var(--accent);
        opacity: 0.8;
    }
    .quick-link:hover i { opacity: 1; }
</style>
@endsection

@section('content')

{{-- ── Welcome Banner ── --}}
<div class="welcome-banner">
    <div class="welcome-text">
        <h1>Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
        <p>Portal administrasi <strong style="color:#c7d2fe;">{{ $tenant->nama_sekolah }}</strong> — CBT SaaS</p>
    </div>
    <div class="welcome-badge-group">
        @if($tenant->status == 'premium')
            <span class="badge badge-premium" style="font-size:0.75rem; padding: 0.3rem 0.75rem;">
                <i class="fa-solid fa-gem"></i> Premium
            </span>
        @elseif($tenant->status == 'trial')
            <span class="badge badge-trial" style="font-size:0.75rem; padding: 0.3rem 0.75rem;">
                <i class="fa-solid fa-hourglass-half"></i> Trial 14 Hari
            </span>
        @else
            <span class="badge badge-free" style="font-size:0.75rem; padding: 0.3rem 0.75rem;">Free</span>
        @endif
        <div class="welcome-icon">
            <i class="fa-solid fa-school-flag"></i>
        </div>
    </div>
</div>

{{-- ── Stat Cards ── --}}
<div class="stats-grid-new">
    <a href="{{ route('admin.majors', ['slug' => session('tenant_slug')]) }}" class="stat-card-new sc-indigo">
        <div class="sc-icon"><i class="fa-solid fa-graduation-cap"></i></div>
        <div class="sc-value">{{ $stats['majors'] }}</div>
        <div class="sc-label">Program Keahlian</div>
        <div class="sc-footer"><i class="fa-solid fa-arrow-right fa-xs"></i> Kelola Jurusan</div>
    </a>

    <a href="{{ route('admin.classes', ['slug' => session('tenant_slug')]) }}" class="stat-card-new sc-emerald">
        <div class="sc-icon"><i class="fa-solid fa-door-open"></i></div>
        <div class="sc-value">{{ $stats['classes'] }}</div>
        <div class="sc-label">Kelas</div>
        <div class="sc-footer"><i class="fa-solid fa-arrow-right fa-xs"></i> Kelola Kelas</div>
    </a>

    <a href="{{ route('admin.teachers', ['slug' => session('tenant_slug')]) }}" class="stat-card-new sc-amber">
        <div class="sc-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
        <div class="sc-value">{{ $stats['teachers'] }}</div>
        <div class="sc-label">Guru</div>
        <div class="sc-footer"><i class="fa-solid fa-arrow-right fa-xs"></i> Kelola Guru</div>
    </a>

    <a href="{{ route('admin.students', ['slug' => session('tenant_slug')]) }}" class="stat-card-new sc-rose">
        <div class="sc-icon"><i class="fa-solid fa-user-graduate"></i></div>
        <div class="sc-value">{{ $stats['students'] }}</div>
        <div class="sc-label">Siswa</div>
        <div class="sc-footer"><i class="fa-solid fa-arrow-right fa-xs"></i> Kelola Siswa</div>
    </a>

    <a href="{{ route('admin.subjects', ['slug' => session('tenant_slug')]) }}" class="stat-card-new sc-violet">
        <div class="sc-icon"><i class="fa-solid fa-book-bookmark"></i></div>
        <div class="sc-value">{{ $stats['subjects'] }}</div>
        <div class="sc-label">Mata Pelajaran</div>
        <div class="sc-footer"><i class="fa-solid fa-arrow-right fa-xs"></i> Kelola Mapel</div>
    </a>
</div>

{{-- ── Info Cards ── --}}
<div class="card" style="margin-bottom: 1.25rem;">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fa-solid fa-building-columns"></i> Informasi Sekolah
        </h3>
        @if($tenant->status == 'trial' && $tenant->trial_ends_at)
            <span class="badge badge-trial">
                <i class="fa-solid fa-clock"></i>
                Berakhir {{ $tenant->trial_ends_at->diffForHumans() }}
            </span>
        @endif
    </div>
    <div class="info-grid">
        <div class="info-card">
            <div class="ic-icon"><i class="fa-solid fa-envelope"></i></div>
            <div class="ic-body">
                <div class="ic-label">Email Resmi</div>
                <div class="ic-value">{{ $tenant->email }}</div>
            </div>
        </div>
        <div class="info-card">
            <div class="ic-icon"><i class="fa-solid fa-phone"></i></div>
            <div class="ic-body">
                <div class="ic-label">Nomor Kontak</div>
                <div class="ic-value">{{ $tenant->phone ?? '—' }}</div>
            </div>
        </div>
        <div class="info-card">
            <div class="ic-icon"><i class="fa-solid fa-link"></i></div>
            <div class="ic-body">
                <div class="ic-label">Subdomain Sekolah</div>
                <div class="ic-value" style="font-family: monospace; font-size: 0.85rem;">
                    /{{ $tenant->slug }}
                </div>
            </div>
        </div>
        <div class="info-card">
            <div class="ic-icon"><i class="fa-solid fa-circle-check" style="color: #34d399;"></i></div>
            <div class="ic-body">
                <div class="ic-label">Status Layanan</div>
                <div class="ic-value" style="color: var(--success);">Aktif ✓</div>
            </div>
        </div>
    </div>
</div>

{{-- ── Quick Links ── --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fa-solid fa-bolt"></i> Akses Cepat
        </h3>
    </div>
    <div class="quick-links">
        <a href="{{ route('admin.majors', ['slug' => session('tenant_slug')]) }}" class="quick-link">
            <i class="fa-solid fa-layer-group"></i> Jurusan
        </a>
        <a href="{{ route('admin.classes', ['slug' => session('tenant_slug')]) }}" class="quick-link">
            <i class="fa-solid fa-door-open"></i> Kelas
        </a>
        <a href="{{ route('admin.subjects', ['slug' => session('tenant_slug')]) }}" class="quick-link">
            <i class="fa-solid fa-book"></i> Mata Pelajaran
        </a>
        <a href="{{ route('admin.teachers', ['slug' => session('tenant_slug')]) }}" class="quick-link">
            <i class="fa-solid fa-chalkboard-user"></i> Guru
        </a>
        <a href="{{ route('admin.students', ['slug' => session('tenant_slug')]) }}" class="quick-link">
            <i class="fa-solid fa-user-graduate"></i> Siswa
        </a>
    </div>
</div>

@endsection
