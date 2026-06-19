@extends('layouts.app')

@section('title', 'Rekap Hasil Nilai')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h1 class="page-title">Rekap Hasil Nilai</h1>
    <p class="page-subtitle">Hasil ujian siswa secara real-time beserta indikator anti-kecurangan</p>
</div>

<div class="card">
    <h3 class="card-title"><i class="fa-solid fa-square-poll-vertical"></i> Hasil Nilai Siswa</h3>
    
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Siswa</th>
                    <th>Kelas</th>
                    <th>Nama Ujian</th>
                    <th>Benar / Total</th>
                    <th>Nilai Asli</th>
                    <th>Nilai Terbobot</th>
                    <th>Mulai / Selesai</th>
                    <th>Integritas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $res)
                    <tr>
                        <td>
                            <strong>{{ $res->student->name }}</strong>
                            <div style="font-size:0.8rem; color:var(--text-secondary)">NISN: {{ $res->student->nisn ?? '-' }}</div>
                        </td>
                        <td><span class="badge badge-free">{{ $res->student->class ? $res->student->class->name : '-' }}</span></td>
                        <td><strong>{{ $res->exam->name }}</strong></td>
                        <td>{{ $res->correct_count }} / {{ $res->exam->total_questions }}</td>
                        <td>
                            <span style="font-size:1.1rem; font-weight:bold; color:var(--accent-color);">
                                {{ $res->score }}
                            </span>
                        </td>
                        <td>
                            <span style="font-size:1.1rem; font-weight:bold; color:#10b981;">
                                {{ $res->weighted_score }}
                            </span>
                        </td>
                        <td>
                            <div style="font-size:0.85rem;">In: {{ $res->started_at ? $res->started_at->format('H:i:s') : '-' }}</div>
                            <div style="font-size:0.85rem; color:var(--text-secondary)">Out: {{ $res->finished_at ? $res->finished_at->format('H:i:s') : '-' }}</div>
                        </td>
                        <td>
                            @if($res->status == 'done')
                                <span class="badge badge-active"><i class="fa-solid fa-circle-check"></i> Jujur</span>
                            @elseif($res->status == 'cheating')
                                <span class="badge badge-suspended"><i class="fa-solid fa-triangle-exclamation"></i> Curang (Tab Switched)</span>
                            @else
                                <span class="badge badge-trial"><i class="fa-solid fa-spinner fa-spin"></i> Pengerjaan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align:center; color:var(--text-secondary)">Belum ada riwayat pengerjaan ujian.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
