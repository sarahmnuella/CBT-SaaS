@extends('layouts.app')

@section('title', 'Jadwalkan Ujian')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h1 class="page-title">Kelola Jadwal Ujian</h1>
    <p class="page-subtitle">Atur token, tipe soal, durasi, dan masa aktif ujian siswa</p>
</div>

<div style="display:grid; grid-template-columns: 1fr 2fr; gap:2rem; align-items: flex-start;">
    <!-- Add Jadwal Card -->
    <div class="card">
        <h3 class="card-title"><i class="fa-solid fa-calendar-plus"></i> Jadwalkan Ujian</h3>
        <form action="{{ route('teacher.exams', ['slug' => session('tenant_slug')]) }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Nama Ujian</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Penilaian Akhir Semester Ganjil" required>
            </div>

            <div class="form-group">
                <label class="form-label">Mata Pelajaran</label>
                <select name="subject_id" class="form-control" required>
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($subjects as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Tipe Soal Ujian</label>
                <select name="type" class="form-control" required>
                    <option value="multiple_choice">Pilihan Ganda (PG)</option>
                    <option value="essay">Esai</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Urutan Soal</label>
                <select name="question_order" class="form-control" required>
                    <option value="random">Acak Soal</option>
                    <option value="sequential">Berurutan</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Jumlah Soal</label>
                <input type="number" name="total_questions" class="form-control" min="1" placeholder="Contoh: 20" required>
            </div>

            <div class="form-group">
                <label class="form-label">Durasi (Menit)</label>
                <input type="number" name="duration" class="form-control" min="1" placeholder="Contoh: 90" required>
            </div>

            <div class="form-group">
                <label class="form-label">Waktu Mulai Akses Ujian</label>
                <input type="datetime-local" name="start_at" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-label">Waktu Selesai Akses Ujian</label>
                <input type="datetime-local" name="end_at" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                Simpan & Aktifkan Ujian
            </button>
        </form>
    </div>

    <!-- Exam List Table -->
    <div class="card">
        <h3 class="card-title"><i class="fa-solid fa-list-check"></i> Daftar Jadwal Ujian CBT</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Ujian</th>
                        <th>Mapel / Tipe</th>
                        <th>Token</th>
                        <th>Durasi</th>
                        <th>Periode Akses</th>
                        <th>Status</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exams as $exam)
                        <tr>
                            <td>
                                <strong>{{ $exam->name }}</strong>
                                <div style="font-size:0.8rem; color:var(--text-secondary)">Jumlah Soal: {{ $exam->total_questions }} ({{ $exam->question_order }})</div>
                            </td>
                            <td>
                                <span class="badge badge-free">{{ $exam->subject->name }}</span>
                                <div style="font-size:0.8rem; color:var(--text-secondary)">{{ $exam->type == 'multiple_choice' ? 'Pilihan Ganda' : 'Esai' }}</div>
                            </td>
                            <td>
                                <span style="font-family:monospace; font-size:1.1rem; font-weight:bold; color:var(--warning-color); background:rgba(245,158,11,0.1); padding:0.25rem 0.5rem; border-radius:4px;">
                                    {{ $exam->token }}
                                </span>
                            </td>
                            <td>{{ $exam->duration }} Menit</td>
                            <td>
                                <div style="font-size:0.85rem;">Mulai: {{ $exam->start_at->format('d M, H:i') }}</div>
                                <div style="font-size:0.85rem; color:var(--text-secondary)">Selesai: {{ $exam->end_at->format('d M, H:i') }}</div>
                            </td>
                            <td>
                                <form action="{{ route('teacher.exam.toggle', ['slug' => session('tenant_slug'), 'id' => $exam->id]) }}" method="POST">
                                    @csrf
                                    @if($exam->is_active)
                                        <button class="btn btn-primary" style="background:#10b981; padding:0.25rem 0.5rem; font-size:0.75rem;">Aktif</button>
                                    @else
                                        <button class="btn btn-danger" style="padding:0.25rem 0.5rem; font-size:0.75rem;">Nonaktif</button>
                                    @endif
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('teacher.exam.delete', ['slug' => session('tenant_slug'), 'id' => $exam->id]) }}" method="POST" onsubmit="return confirm('Menghapus jadwal ujian ini akan menghapus riwayat nilai ujian yang bersangkutan. Lanjutkan?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" style="padding:0.4rem 0.8rem; font-size:0.8rem;">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; color:var(--text-secondary)">Belum ada ujian terjadwal.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
