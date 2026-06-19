@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h1 class="page-title">Dashboard Guru</h1>
    <p class="page-subtitle">Kelola bank soal, jadwalkan ujian CBT, dan pantau rekap hasil nilai siswa Anda.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
            <span class="stat-label">Bank Soal</span>
            <span style="color:#6366f1; background:rgba(99,102,241,0.1); width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.875rem;"><i class="fa-solid fa-folder-open"></i></span>
        </div>
        <div class="stat-value">{{ $stats['questions'] }}</div>
        <div class="stat-meta">Butir Soal Anda</div>
    </div>
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
            <span class="stat-label">Jadwal Ujian</span>
            <span style="color:#10b981; background:rgba(16,185,129,0.1); width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.875rem;"><i class="fa-solid fa-calendar-check"></i></span>
        </div>
        <div class="stat-value">{{ $stats['exams'] }}</div>
        <div class="stat-meta">Sesi Ujian Aktif</div>
    </div>
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
            <span class="stat-label">Siswa Selesai Ujian</span>
            <span style="color:#ec4899; background:rgba(236,72,153,0.1); width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.875rem;"><i class="fa-solid fa-square-poll-vertical"></i></span>
        </div>
        <div class="stat-value">{{ $stats['results'] }}</div>
        <div class="stat-meta">Lembar Jawaban Masuk</div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="margin-bottom: 1rem;">
        <h3 class="card-title"><i class="fa-solid fa-graduation-cap"></i> Panduan Singkat CBT Guru</h3>
    </div>
    <ul style="padding-left: 1.5rem; line-height: 1.8; color: var(--text-3)">
        <li>Masukkan bank soal pilihan ganda atau esai terlebih dahulu melalui tab <a href="{{ route('teacher.questions', ['slug' => session('tenant_slug')]) }}" style="color:var(--accent)">Bank Soal</a>.</li>
        <li>Buat jadwal ujian baru di tab <a href="{{ route('teacher.exams', ['slug' => session('tenant_slug')]) }}" style="color:var(--accent)">Jadwal Ujian</a> dengan token ujian acak.</li>
        <li>Bagikan token ujian kepada siswa peserta agar mereka dapat masuk ke CBT Engine.</li>
        <li>Lihat hasil ujian, nilai terbobot, hingga status integritas ujian di menu <a href="{{ route('teacher.results', ['slug' => session('tenant_slug')]) }}" style="color:var(--accent)">Rekap Hasil</a>.</li>
    </ul>
</div>
@endsection
