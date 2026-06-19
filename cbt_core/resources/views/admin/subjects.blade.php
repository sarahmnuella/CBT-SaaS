@extends('layouts.app')

@section('title', 'Kelola Mata Pelajaran')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h1 class="page-title">Kelola Mata Pelajaran</h1>
    <p class="page-subtitle">Daftar mata pelajaran atau kurikulum aktif</p>
</div>

<div style="display:grid; grid-template-columns: 1fr 2fr; gap:2rem; align-items: flex-start;">
    <!-- Add Mapel Card -->
    <div class="card">
        <h3 class="card-title"><i class="fa-solid fa-plus-circle"></i> Tambah Pelajaran</h3>
        <form action="{{ route('admin.subjects', ['slug' => session('tenant_slug')]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Mata Pelajaran</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Matematika" required>
            </div>
            <div class="form-group">
                <label class="form-label">Kode Mapel (Opsional)</label>
                <input type="text" name="code" class="form-control" placeholder="Conting: MTK-12">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                Tambah Pelajaran
            </button>
        </form>
    </div>

    <!-- Mapel List Table -->
    <div class="card">
        <h3 class="card-title"><i class="fa-solid fa-list"></i> Daftar Pelajaran</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Mata Pelajaran</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $index => $subject)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><span style="font-family:monospace; background:rgba(255,255,255,0.05); padding:0.25rem 0.5rem; border-radius:4px;">{{ $subject->code ?? '-' }}</span></td>
                            <td><strong>{{ $subject->name }}</strong></td>
                            <td>
                                <form action="{{ route('admin.subject.delete', ['slug' => session('tenant_slug'), 'id' => $subject->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini? Soal dan Ujian terkait akan ikut terhapus!');">
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
                            <td colspan="4" style="text-align:center; color:var(--text-secondary)">Belum ada data mata pelajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
