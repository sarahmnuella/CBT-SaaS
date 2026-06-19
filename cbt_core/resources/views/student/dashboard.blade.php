@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h1 class="page-title">Selamat Datang, {{ auth()->user()->name }}!</h1>
    <p class="page-subtitle">Pastikan koneksi internet stabil sebelum memulai ujian CBT.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
            <span class="stat-label">Ujian Diikuti</span>
            <span style="color:#6366f1; background:rgba(99,102,241,0.1); width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.875rem;"><i class="fa-solid fa-file-signature"></i></span>
        </div>
        <div class="stat-value">{{ $stats['taken'] }}</div>
        <div class="stat-meta">Ujian selesai dikerjakan</div>
    </div>
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
            <span class="stat-label">Rata-rata Nilai</span>
            <span style="color:#10b981; background:rgba(16,185,129,0.1); width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.875rem;"><i class="fa-solid fa-square-poll-vertical"></i></span>
        </div>
        <div class="stat-value">{{ number_format($stats['average_score'], 1) }}</div>
        <div class="stat-meta">Indeks nilai akademik</div>
    </div>
    <div class="stat-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
            <span class="stat-label">Ujian Mendatang</span>
            <span style="color:#f59e0b; background:rgba(245,158,11,0.1); width: 32px; height: 32px; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 0.875rem;"><i class="fa-solid fa-clock"></i></span>
        </div>
        <div class="stat-value">{{ $stats['upcoming'] }}</div>
        <div class="stat-meta">Sesi ujian yang akan datang</div>
    </div>
</div>

<div class="card">
    <div class="card-header" style="margin-bottom: 1rem;">
        <h3 class="card-title"><i class="fa-solid fa-circle-exclamation"></i> Tata Tertib Ujian CBT Online</h3>
    </div>
    <ul style="padding-left: 1.5rem; line-height: 1.8; color: var(--text-3); margin-bottom: 1.5rem;">
        <li>Siapkan token ujian yang diberikan oleh pengawas / guru mata pelajaran Anda.</li>
        <li><strong>DILARANG KERAS</strong> berpindah tab browser, menutup browser, atau meminimalkan jendela selama ujian berlangsung.</li>
        <li>Platform memiliki pendeteksi kecurangan otomatis. Jika Anda meninggalkan halaman ujian sebanyak 1 kali, status pengerjaan Anda akan ditandai sebagai <strong>Curang</strong> dan lembar jawaban akan langsung dikunci otomatis.</li>
        <li>Jawaban Anda otomatis tersimpan (Auto-Save) setiap kali Anda memilih opsi jawaban.</li>
    </ul>
    <div>
        <a href="{{ route('student.exams', ['slug' => session('tenant_slug')]) }}" class="btn btn-primary">
            Lihat Daftar Ujian <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</div>
@endsection
