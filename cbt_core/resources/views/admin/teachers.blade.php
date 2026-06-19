@extends('layouts.app')

@section('title', 'Kelola Data Guru')

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h1 class="page-title">Kelola Data Guru</h1>
    <p class="page-subtitle">Daftar tenaga pengajar yang memiliki akses pembuat soal & jadwal ujian</p>
</div>

<div style="display:grid; grid-template-columns: 1fr 2fr; gap:2rem; align-items: flex-start;">
    <!-- Add Guru Card -->
    <div class="card">
        <h3 class="card-title"><i class="fa-solid fa-user-plus"></i> Tambah Guru</h3>
        <form action="{{ route('admin.teachers', ['slug' => session('tenant_slug')]) }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso, S.Pd." required>
            </div>
            <div class="form-group">
                <label class="form-label">NIP / Kode Identitas</label>
                <input type="text" name="nip" class="form-control" placeholder="Contoh: 19820304...">
            </div>
            <div class="form-group">
                <label class="form-label">Email Guru</label>
                <input type="email" name="email" class="form-control" placeholder="Contoh: budi@sekolah.sch.id" required>
            </div>
            <div class="form-group">
                <label class="form-label">No. Telepon / WA</label>
                <input type="text" name="phone" class="form-control" placeholder="Contoh: 0812...">
            </div>
            <div class="form-group">
                <label class="form-label">Password Akun Guru</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">
                Simpan & Daftarkan Guru
            </button>
        </form>
    </div>

    <!-- Guru List Table -->
    <div class="card">
        <h3 class="card-title"><i class="fa-solid fa-users"></i> Daftar Guru</h3>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama Lengkap</th>
                        <th>Email / Log</th>
                        <th>Telepon</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                        <tr>
                            <td><span style="font-family:monospace">{{ $teacher->nip ?? '-' }}</span></td>
                            <td><strong>{{ $teacher->name }}</strong></td>
                            <td>{{ $teacher->email }}</td>
                            <td>{{ $teacher->phone ?? '-' }}</td>
                            <td>
                                <form action="{{ route('admin.teacher.delete', ['slug' => session('tenant_slug'), 'id' => $teacher->id]) }}" method="POST" onsubmit="return confirm('Menghapus guru ini akan menghapus akun login guru serta bank soal buatannya. Lanjutkan?');">
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
                            <td colspan="5" style="text-align:center; color:var(--text-secondary)">Belum ada data guru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
